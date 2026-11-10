const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { parse, compileScript } = require('@vue/compiler-sfc');
const { compile, createSSRApp } = require('vue');
const { renderToString } = require('@vue/server-renderer');

function component(name, globals = {}) {
    const filename = path.resolve(__dirname, '../../resources/js/components', name + '.vue');
    const { descriptor, errors } = parse(fs.readFileSync(filename, 'utf8'), { filename });
    assert.deepEqual(errors, []);
    compileScript(descriptor, { id: name });
    const script = descriptor.script.content.replace(/^import .*;?\r?$/gm, '').replace('export default', 'return');
    const options = new Function(...Object.keys(globals), script)(...Object.values(globals));
    options.render = compile(descriptor.template.content);
    return options;
}

test('homepage cards link to RN, 2, and 6 clothing filters; other browse links stay unfiltered', async () => {
    const frontpage = component('FrontPage/FrontPage');
    frontpage.setup = () => ({ email: '', subscribe: () => {} });
    const app = createSSRApp(frontpage);
    app.component('frontpagefeaturedproducts-component', { render: () => null });
    const html = await renderToString(app);
    for (const idade of ['RN', '2', '6']) {
        assert.ok(html.includes(`href="/vitrine?idade=${idade}&amp;categoria=3"`));
    }
    // Hero, toys/accessories, and the featured-section link remain unfiltered.
    assert.equal(html.split('href="/vitrine"').length - 1, 3);
});

for (const idade of ['RN', '2', '6']) {
    test(`catalog starts with size ${idade} selected and sends it on the first request and pagination`, async () => {
        const requests = [];
        const options = component('AllProductsPage/AllProducts', {
            window: { location: { search: `?idade=${idade}&categoria=3` } },
            axios: async (url, { params }) => {
                requests.push({ url, params });
                return { data: { data: [], meta: { current_page: params.page, last_page: 3 } } };
            },
        });
        const state = options.data();
        for (const [name, method] of Object.entries(options.methods)) state[name] = method.bind(state);
        let categoriesLoaded = 0;
        state.loadCategorias = () => { categoriesLoaded++; };
        options.mounted.call(state);
        await new Promise(setImmediate);
        assert.equal(categoriesLoaded, 1);
        assert.equal(requests.length, 1);
        assert.equal(requests[0].params.idade, idade);
        assert.equal(requests[0].params.categoria, 3);
        assert.equal(requests[0].params.page, 1);
        state.loadMore();
        await new Promise(setImmediate);
        assert.equal(requests[1].params.idade, idade);
        assert.equal(requests[1].params.categoria, 3);
        assert.equal(requests[1].params.page, 2);
        state.filtros.nome = 'Demo';
        state.clearFilters();
        assert.equal(state.filtros.idade, '');
        assert.equal(state.filtros.categoria, '');
        assert.equal(state.filtros.nome, 'Demo');

        const originalData = options.data;
        options.data = () => ({ ...originalData(), categorias: [{ id: 3, nome: 'Roupas' }] });
        const app = createSSRApp(options);
        app.component('frontpageproductcard-component', { render: () => null });
        const html = await renderToString(app);
        assert.match(html, new RegExp(`bg-twprimary text-white[^>]*>\\s*${idade}\\s*</span>`));
        assert.match(html, /bg-twprimary text-white[^>]*>\s*Roupas\s*<\/span>/);
    });
}

test('catalog ignores unsupported URL filters and preserves unfiltered navigation', () => {
    for (const search of ['', '?idade=5&categoria=invalid', '?idade=RN-24&categoria=-1', '?categoria=9007199254740992']) {
        const options = component('AllProductsPage/AllProducts', { window: { location: { search } } });
        assert.equal(options.data().filtros.idade, '');
        assert.equal(options.data().filtros.categoria, '');
    }
});
