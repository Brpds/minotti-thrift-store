/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * import vueX
 */

import Vuex from 'vuex';

const store = new Vuex.Store({
    state:{
        item: {},
        activeItem:{
            fornecedor:{
                id: '',
                nome: ''
            },
            marca:{
                id: '',
                nome: ''
            },
            categoria:{
                id: '',
                nome: ''
            }
        },
        transacao: {
            status: '',
            mensagem: '',
            dados: ''
        }
    },
    mutations:{
        setActiveItem(state, item) {
          state.activeItem = {
            nome: item.nome || '',
            fornecedor: {
              id: item.fornecedor?.id || '',
              nome: item.fornecedor?.nome || ''
            },
            marca: {
              id: item.marca?.id || '',
              nome: item.marca?.nome || ''
            },
            categoria: {
              id: item.categoria?.id || '',
              nome: item.categoria?.nome || ''
            },
            ...item
          }
        }
        
    },
})

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);
import LoginComponent from './components/Login.vue';
app.component('login-component', LoginComponent);
import HomeComponent from './components/Home.vue';
app.component('home-component', HomeComponent);
import NavCard from './components/NavCard.vue';
app.component('navCard-component', NavCard);
import ProdutoCard from './components/Produtos.vue';
app.component('produto-card', ProdutoCard);
import InputContainer from './components/InputContainer.vue';
app.component('input-container', InputContainer);
import TableComponent from './components/Table.vue';
app.component('table-component', TableComponent);
import CardComponent from './components/Card.vue';
app.component('card-component', CardComponent);
import ModalComponent from './components/Modal.vue';
app.component('modal-component', ModalComponent);
import MarcaCard from './components/Marcas.vue';
app.component('marca-component', MarcaCard);
import AvaliacoesComponent from './components/Avaliacoes.vue';
app.component('avaliacoes-component', AvaliacoesComponent);
import MainCard from './components/MainCard.vue';
app.component('maincard-component', MainCard);
import Fornecedores from './components/Fornecedores.vue';
app.component('fornecedores-component', Fornecedores);
import Pagination from './components/Pagination.vue';
app.component('pagination-component', Pagination);
import Alert from './components/Alert.vue';
app.component('alert-component', Alert);
import Spa from './components/Spa.vue';
app.component('spa-component', Spa);
import ProdutoNovo from './components/ProdutoNovo.vue';
app.component('newProduct-component', ProdutoNovo);
import MarcaNovo from './components/MarcaNovo.vue';
app.component('newMarca-component', MarcaNovo);
import FornecedorNovo from './components/FornecedorNovo.vue';
app.component('newFornecedor-component', FornecedorNovo);
import Select from './components/Select.vue';
app.component('select-component', Select);
import PriceInput from './components/PriceInput.vue';
app.component('price-input', PriceInput);
import Multiselect from './components/SelectSearch.vue';
app.component('multi-select', Multiselect);
import Categoria from './components/Categoria.vue';
app.component('categoria-component', Categoria);

//FrontPage components
import FrontPage from './components/FrontPage/FrontPage.vue';
app.component('frontpage-component', FrontPage);
import ViewProduct from './components/ProductDetailsPage/ViewProduct.vue';
app.component('viewproduct-component', ViewProduct);
import AllProducts from './components/AllProductsPage/AllProducts.vue';
app.component('allproducts-component', AllProducts);
import SellWithUs from './components/SellWithUsPage/SellWithUs.vue';
app.component('sellwithus-component', SellWithUs);
import AboutUs from './components/AboutUsPage/AboutUs.vue';
app.component('aboutus-component', AboutUs);
import FAQ from './components/FAQPage/FAQ.vue';
app.component('faq-component', FAQ);
import FrontPageProductCard from './components/FrontPageProductCard/FrontPageProductCard.vue';
app.component('frontpageproductcard-component', FrontPageProductCard);
import FrontPageFeaturedProducts from './components/FrontPageFeaturedProducts/FrontPageFeaturedProducts.vue';
app.component('frontpagefeaturedproducts-component', FrontPageFeaturedProducts);
import NotFoundPage from './components/NotFoundPage/NotFoundPage.vue';
app.component('notfound-component', NotFoundPage);
import ProductSubmission from './components/ProductSubmission/ProductSubmission.vue';
app.component('productsubmission-component', ProductSubmission);
import ImgSubmit from './components/ImgSubmit.vue';
app.component('imgsubmit-component', ImgSubmit);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(store);
app.mount('#app');
