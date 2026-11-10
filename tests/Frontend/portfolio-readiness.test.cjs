const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const { parse, compileScript, compileTemplate } = require('@vue/compiler-sfc');

const root = path.resolve(__dirname, '../..');

function component(name, globals = {}) {
    const filename = path.join(root, 'resources/js/components', name + '.vue');
    const source = fs.readFileSync(filename, 'utf8');
    const { descriptor, errors } = parse(source, { filename });
    assert.deepEqual(errors, []);
    compileScript(descriptor, { id: name });
    const template = compileTemplate({ source: descriptor.template.content, filename, id: name });
    assert.deepEqual(template.errors, []);
    const script = descriptor.script.content.replace(/^import .*;?\r?$/gm, '')
        .replace('export default', 'return');
    return new Function(...Object.keys(globals), script)(...Object.values(globals));
}

test('login acquires a JWT before submitting the existing session form', async () => {
    const calls = [];
    const document = { cookie: '' };
    const login = component('Login', {
        document,
        fetch: async (url, options) => {
            calls.push('jwt');
            assert.equal(url, '/api/login');
            assert.equal(options.method, 'post');
            assert.equal(options.body.get('email'), 'admin@example.test');
            assert.equal(options.body.get('password'), 'test-password');
            return { ok: true, json: async () => ({ token: 'demo-token' }) };
        },
    });
    const state = { ...login.data(), email: 'admin@example.test', password: 'test-password' };
    // The component uses a promise chain; drain it before inspecting the handoff.
    login.methods.login.call(state, { target: { submit: () => {
        assert.match(document.cookie, /^token=demo-token;/);
        calls.push('session');
    } } });
    await new Promise(setImmediate);
    assert.deepEqual(calls, ['jwt', 'session']);
    assert.equal(state.loginError, '');
});

for (const [name, fetch] of [
    ['invalid credentials', async () => ({ ok: false, json: async () => ({ erro: 'Denied' }) })],
    ['missing token', async () => ({ ok: true, json: async () => ({}) })],
    ['network failure', async () => { throw new Error('Unavailable'); }],
]) {
    test(`login does not submit the session form on ${name}`, async () => {
        const document = { cookie: '' };
        const login = component('Login', { fetch, document });
        const state = login.data();
        let submitted = false;
        login.methods.login.call(state, { target: { submit: () => { submitted = true; } } });
        await new Promise(setImmediate);
        assert.equal(submitted, false);
        assert.equal(document.cookie, '');
        assert.ok(state.loginError);
    });
}

test('editing a product preloads its existing condition and size', async () => {
    const item = { id: 1, nome: 'Demo', condicao: 'Seminova', tamanho: 'M' };
    const products = component('Produtos', { axios: { get: async () => ({ data: item }) } });
    const state = {
        $store: { state: { item: { id: 1 } }, commit: () => {} },
        urlBase: '/api/v1/produtos',
    };
    await products.methods.editarVerProdutoCarregarInfo.call(state);
    assert.equal(state.condicaoProduto, 'Seminova');
    assert.equal(state.tamanho, 'M');
});
