const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { parse } = require('@vue/compiler-sfc');
const { compile, createSSRApp, h } = require('vue');
const { renderToString } = require('@vue/server-renderer');

function component(name, globals = {}) {
    const source = fs.readFileSync(path.resolve(__dirname, '../../resources/js/components', name + '.vue'), 'utf8');
    const { descriptor, errors } = parse(source);
    assert.deepEqual(errors, []);
    const script = descriptor.script.content.replace(/^import .*;?\r?$/gm, '').replace('export default', 'return');
    const options = new Function(...Object.keys(globals), script)(...Object.values(globals));
    options.render = compile(descriptor.template.content);
    return options;
}

function withData(options, data) {
    const original = options.data;
    options.data = function () { return { ...(original ? original.call(this) : {}), ...data }; };
    return options;
}

const relativeImage = 'imagens/produtos/synthetic.png';
const imageUrl = '/storage/' + relativeImage;
const product = {
    id: 1, nome: 'Synthetic', imagem: imageUrl, valor_venda: 1000,
    tamanho: 'M', descricao: 'Synthetic product', condicao: 'Seminova',
};

test('catalog cards display the API image URL unchanged', async () => {
    const options = withData(component('AllProductsPage/AllProducts'), { produtos: [product] });
    const app = createSSRApp(options);
    app.component('frontpageproductcard-component', component('FrontPageProductCard/FrontPageProductCard'));
    const html = await renderToString(app);
    assert.ok(html.includes(`src="${imageUrl}"`));
});

test('featured cards display the API image URL unchanged', async () => {
    const options = withData(component('FrontPageFeaturedProducts/FrontPageFeaturedProducts'), { produtosDestaque: [product] });
    const html = await renderToString(createSSRApp(options));
    assert.ok(html.includes(`src="${imageUrl}"`));
});

test('product details display the API image URL unchanged', async () => {
    const options = withData(component('ProductDetailsPage/ViewProduct', {
        window: { location: { origin: 'http://localhost:8000' } },
    }), { produto: product, valorVenda: 1000 });
    const app = createSSRApp(options);
    app.component('notfound-component', { render: () => null });
    const html = await renderToString(app);
    assert.ok(html.includes(`src="${imageUrl}"`));
});

test('dashboard table and all existing-image modals use the shared public prefix', async () => {
    const storedProduct = { ...product, imagem: relativeImage, etiqueta: 'IMG-TEST', parte_loja: 500 };
    const options = withData(component('Produtos'), { produtosDados: [storedProduct] });
    const app = createSSRApp(options);
    app.config.globalProperties.$store = {
        state: { item: storedProduct, activeItem: storedProduct, transacao: { dados: {} } },
    };
    app.component('card-component', component('Card'));
    app.component('modal-component', component('Modal'));
    app.component('table-component', component('Table'));
    // Form controls are outside this rendering test; retain their slots.
    const control = { setup: (_, { slots }) => () => h('div', Object.values(slots).flatMap(slot => slot())) };
    for (const name of ['alert-component', 'imgsubmit-component', 'input-container', 'multi-select',
        'pagination-component', 'price-input', 'select-component']) {
        app.component(name, control);
    }
    const html = await renderToString(app);
    assert.equal(html.split(`src="${imageUrl}"`).length - 1, 4);
    assert.ok(!html.includes('website-here'));
});
