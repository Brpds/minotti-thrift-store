<template>
    <div class="mt-[-1.25rem] min-h-screen">
        <!-- Filter Bar -->
        <div class="sticky top-[60px] z-40 bg-background/95 backdrop-blur-sm border-b border-surface-variant/30 py-4 px-6 flex justify-end items-center">
            <div class="max-w-7xl mx-auto w-full flex items-center gap-3 relative">
                <div class="relative flex-grow max-w-md ml-auto">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-twprimary text-sm" data-icon="search">search</span>
                    <input id="searchInput" v-model="filtros.nome" class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border-none rounded-full text-sm placeholder:text-on-surface-variant/50 focus:ring-twprimary focus:ring-[#d087cb]/80 transition-all" min="2" max="100" placeholder="Pesquisar..." type="text"/>
                </div>
                <button class="flex max-w-[30%] justify-center items-center gap-2 bg-twprimary text-white px-5 py-2.5 rounded-full whitespace-nowrap text-sm font-semibold shadow-md active:scale-95 transition-all" @click="toggleFilter()">
                    <span class="material-symbols-outlined text-sm" data-icon="tune">tune</span>
                        Filtrar
                </button>
                <div v-show="filterOpen" id="filterPanel" class="max-h-[70vh] absolute top-full right-0 mt-2 w-72 bg-surface border border-outline-variant rounded-2xl shadow-xl z-50 overflow-y-auto scroll-smooth animate-in fade-in slide-in-from-top-2 duration-200">
                    <div class="p-5 space-y-6">
                        <!-- Stage Filter -->
                        <div class="space-y-3">
                          <h4 class="text-xs font-bold uppercase tracking-widest text-twprimary">Idade</h4>

                          <div class="flex flex-wrap gap-2">
                            <span
                                v-for="itemIdade in idades"
                                :key="itemIdade.value"
                                @click="filtros.idade === itemIdade.value ? filtros.idade = '' : filtros.idade = itemIdade.value"
                                :class="[
                                  'px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer transition-colors',
                                  filtros.idade === itemIdade.value
                                    ? 'bg-twprimary text-white'
                                    : 'bg-surface-container-high text-on-surface hover:bg-primary-container hover:text-on-primary-container'
                                ]"
                            >
                                {{ itemIdade.label }}
                            </span>
                          </div>
                        </div>
                        <!-- Shoes Filter -->
                        <div class="space-y-3">
                          <h4 class="text-xs font-bold uppercase tracking-widest text-twprimary">Calçados</h4>
                          <div class="flex flex-wrap gap-2">
                            <span
                                v-for="item in calcados"
                                :key="item.value"
                                @click="filtros.tamanho === item.value ? filtros.tamanho = '' : filtros.tamanho = item.value"
                                :class="[
                                  'px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer transition-colors',
                                  filtros.tamanho === item.value
                                    ? 'bg-twprimary text-white'
                                    : 'bg-surface-container-high text-on-surface hover:bg-primary-container hover:text-on-primary-container'
                                ]"
                            >
                                {{ item.label }}
                            </span>
                          </div>
                        </div>

                        <!-- Shoes Filter -->
                        <div class="space-y-3">
                          <h4 class="text-xs font-bold uppercase tracking-widest text-twprimary">Categorias</h4>
                          <div class="flex flex-wrap gap-2">
                            <span
                                v-for="item in categorias"
                                :key="item.id"
                                @click="filtros.categoria === item.id ? filtros.categoria = '' : filtros.categoria = item.id"
                                :class="[
                                  'px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer transition-colors',
                                  filtros.categoria === item.id
                                    ? 'bg-twprimary text-white'
                                    : 'bg-surface-container-high text-on-surface hover:bg-primary-container hover:text-on-primary-container'
                                ]"
                            >
                                {{ item.nome }}
                            </span>
                          </div>
                        </div>
                        <!-- Condition Filter -->
                        <div class="space-y-3">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-twprimary">Condição</h4>
                            <div class="flex flex-wrap gap-2">
                                <span
                                  @click="filtros.condicao = ''"
                                  :class="pillClass(filtros.condicao === '')"
                                >
                                  Todas
                                </span>
                                <span
                                  @click="filtros.condicao = 'nova'"
                                  :class="pillClass(filtros.condicao === 'nova')"
                                >
                                  Novas
                                </span>
                              
                                <span
                                  @click="filtros.condicao = 'seminova'"
                                  :class="pillClass(filtros.condicao === 'seminova')"
                                >
                                  Seminovas
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-4 flex justify-center items-center border-t border-outline-variant/30">
                        <button class="text-xs font-bold text-on-surface-variant hover:text-twprimary transition-colors" @click="clearFilters()">Limpar Filtros</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6">
        <!-- Title Section -->
        <section class="py-8">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-on-surface">Nossos Tesouros</h1>
            </div>
        </div>
        <!-- Product Grid: 2-column mobile layout -->
         <div v-if="loading" class="text-center py-4">
                Carregando...
        </div>
        <div class="grid grid-cols-2 gap-x-4 gap-y-10">
            <!--Product card list-->
            <div v-for="produto in produtos" :key="produto.id">
                <a :href="`/vitrine/${produto.id}`" class="text-decoration-none">
                    <frontpageproductcard-component
                        :produto = "produto"
                    ></frontpageproductcard-component>
                </a>
            </div>
        </div>

        <!-- Load More Button: Replaces infinite scroll indicator -->
        <div class="mt-16 mb-12 flex justify-center">
            <button v-show="hasMore" class="bg-surface-container-high hover:bg-surface-container text-twprimary px-10 py-3.5 rounded-full text-xs font-bold uppercase tracking-widest shadow-sm transition-all active:scale-95"
                @click="loadMore()"
            >
                Carregar Mais
            </button>
        </div>
        </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        
        data(){
            const params = new URLSearchParams(typeof window === 'undefined' ? '' : window.location.search);
            const idade = params.get('idade') || '';
            const categoria = params.get('categoria') || '';
            const idades = [
                { label: 'RN', value: 'RN' },
                { label: 'P', value: 'P' },
                { label: 'M', value: 'M' },
                { label: 'G', value: 'G' },
                { label: '1', value: '1' },
                { label: '2', value: '2' },
                { label: '3', value: '3' },
                { label: '4', value: '4' },
                { label: '6', value: '6' },
                { label: '8', value: '8' },
                { label: '10', value: '10' },
                { label: '12', value: '12' },
            ];

            return {
                produtos: [],
                loading: false,
                page: 1,
                hasMore: true,
                filterOpen : false,
                filtros: {
                    nome: '',
                    condicao: '',
                    categoria: /^[1-9]\d*$/.test(categoria) && Number.isSafeInteger(Number(categoria)) ? Number(categoria) : '',
                    idade: idades.some(item => item.value === idade) ? idade : '',
                    tamanho: '',
                    order_by: ''
                },
                categorias:[],
                idades,
                calcados: [
                    {label: '17', value: '17' },
                    {label: '18', value: '18' },
                    {label: '19', value: '19' },
                    {label: '20', value: '20' },
                    {label: '21', value: '21' },
                    {label: '22', value: '22' },
                    {label: '23', value: '23' },
                    {label: '24', value: '24' },
                    {label: '25', value: '25' },
                    {label: '26', value: '26' },
                    {label: '27', value: '27' },
                    {label: '28', value: '28' },
                    {label: '29', value: '29' },
                    {label: '30', value: '30' },
                    {label: '31', value: '31' },
                    {label: '32', value: '32' },
                    {label: '33', value: '33' },
                    {label: '34', value: '34' },
                ],
                debounceTimer: null,
            }
        },
        methods:{
            async carregarProdutos(){

                const res = await axios('/api/v1/vitrine', {params: {page:this.page, ...this.busca, ...this.filtros}});

                this.produtos.push(...res.data.data);
                this.hasMore = res.data.meta.current_page < res.data.meta.last_page;

            },
            loadMore(){
                this.page++;
                this.carregarProdutos();
            },
            toggleFilter(){
                this.filterOpen = !this.filterOpen
            },
            applyFilters(){
                this.page = 1;
                this.produtos = [];
                this.carregarProdutos();
            },
            pillClass(active) {
                return [
                  'px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer transition-colors',
                  active
                    ? 'bg-twprimary text-white'
                    : 'bg-surface-container-high text-on-surface hover:bg-primary-container hover:text-on-primary-container'
                ]
            },
            clearFilters(){
                return this.filtros = {
                    nome: this.filtros.nome,
                    condicao: '',
                    categoria: '',
                    idade: '',
                    tamanho: '',
                    order_by: ''
                }
            },
            async loadCategorias(){
                const categoriasList = await axios('http://127.0.0.1:8000/api/categorias/publiclist');
                this.categorias = categoriasList.data;
            },
        },
        watch: {
            filtros: {
                deep: true,
                handler() {
                    //timer para o carregamento da lista após clicar nos filtros
                    clearTimeout(this.debounceTimer);
                    
                    this.debounceTimer = setTimeout(() => {

                        this.page = 1
                        this.produtos = []
                        this.carregarProdutos()
                    }, 300) //ajustar aqui se necessário mais tempo
                }
            },
        },
        mounted(){
            this.carregarProdutos();
            this.loadCategorias();
        }
    }
</script>
