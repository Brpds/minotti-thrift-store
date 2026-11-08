<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Busca de Categorias">
                    <template v-slot:conteudo>
                        <div class="row">
                                <div class="col mb-3">
                                    <input-container id="inputIdContainer" titulo="ID" id-help="idHelp"
                                        texto-ajuda="Opcional. Informe o ID da Categoria"
                                    >
                                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID"
                                        v-model="busca.id">
                                    </input-container>
                                </div>
                                <div class="col mb-3">
                                    <input-container id="inputNomeContainer" titulo="Nome da Categoria" id-help="nomeHelp"
                                        texto-ajuda="Opcional. Informe o nome da Categoria"
                                    >
                                        <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Categoria"
                                        v-model="busca.nome">
                                    </input-container>
                                </div>
                            </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary float-end" @click="buscarCategoria()">Buscar</button>
                    </template>
                </card-component>
                <card-component titulo="Lista de Categorias">
                    <template v-slot:conteudo>
                        <table-component 
                        :dados="categoriasDados"
                        :ver="{
                            visivel: true,
                            dataToggle:'modal',
                            dataTarget:'#modalCategoriaVer'
                        }"
                        :editar="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalCategoriaAtualizar'
                        }"
                        :excluir="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalCategoriaRemover'
                        }"
                        :titulos="{
                            id:{titulo: 'ID', tipo: 'text'},
                            nome: {titulo: 'Nome', tipo: 'text'},
                        }"
                        >
                        </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <pagination-component>
                                    <li v-for="l, key in categorias.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'">
                                      <a class="page-link" v-html="l.label" @click="paginacao(l)">
                                        
                                      </a>
                                    </li>
                                </pagination-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalCategoria"
                                >Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!--Lista de Categorias fim-->

                <!--Início do modal de inclusão de Categoria-->
                <modal-component id="modalCategoria" titulo="Adicionar Categoria">
                    <template v-slot:alertas>
                        <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="this.$store.state.transacao.status == 'sucesso'"></alert-component>
                        <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca." v-if="this.$store.state.transacao.status == 'erro'"></alert-component>
                    </template>
                    <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                    <div class="form-group">
                        <input-container id="novaCategoriaContainer" titulo="Nome da Categoria" id-help="novaCategoriaHelp"
                                        texto-ajuda="Informe o nome da Categoria"
                                    >
                            <input type="text" class="form-control" id="novaCategoria" aria-describedby="novaCategoriaHelp" placeholder="Nome da Categoria" v-model="nomeCategoria">
                        </input-container>
                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()" v-if="$store.state.transacao.status != 'sucesso'">Salvar</button>
                </template>

                </modal-component>
                <!--Fim do modal de inclusão de Categoria-->

                <!--Início do modal de Ver de Categoria-->
                <modal-component id="modalCategoriaVer" titulo="Ver Categoria">
                    <template v-slot:conteudo>
                        <input-container titulo="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container>
                        <input-container titulo="Nome da Categoria">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                    </template>
                </modal-component>
                <!--Fim do modal de Ver de Categoria-->

                <!--Início do modal de Remover de Categoria-->
                <modal-component id="modalCategoriaRemover" titulo="Remover Categoria">
                    <template v-slot:alertas>
                        <alert-component
                         tipo="success" titulo="Operação realizada com sucesso!" :detalhes="this.$store.state.transacao"
                         v-if="$store.state.transacao.status == 'sucesso'"
                        >
                        </alert-component>
                        <alert-component
                         tipo="danger" titulo="Operação falhou!" :detalhes="this.$store.state.transacao"
                         v-if="$store.state.transacao.status == 'erro'"
                        >
                        </alert-component>
                    </template>
                    <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                        <input-container titulo="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container>
                        <input-container titulo="Nome da Marca">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                        <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    </template>
                </modal-component>
                <!--Fim do modal de Remover de Categoria-->

                <!--Início do modal de atualização de Categoria-->
                <modal-component id="modalCategoriaAtualizar" titulo="Atualizar Categoria">

                    <template v-slot:alertas>
                        <alert-component
                         tipo="success" titulo="Operação realizada com sucesso!" :detalhes="this.$store.state.transacao"
                         v-if="$store.state.transacao.status == 'sucesso'"
                        >
                        </alert-component>
                        <alert-component
                         tipo="danger" titulo="Operação falhou!" :detalhes="this.$store.state.transacao"
                         v-if="$store.state.transacao.status == 'erro'"
                        >
                        </alert-component>
                    </template>

                <template v-slot:conteudo>
                <div class="form-group" v-if="$store.state.transacao.status != 'sucesso'">
                    <input-container id="atualizarMarca" titulo="Nome da Marca" id-help="atualizarMarcaHelp"
                                    texto-ajuda="Informe o nome da Marca"
                                >
                        <input type="text" class="form-control" id="atualizarMarca" aria-describedby="atualizarMarcaHelp" placeholder="Nome da Marca" v-model="$store.state.item.nome">
                    </input-container>
                </div>

                </template>

                <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()" v-if="$store.state.transacao.status != 'sucesso'">Atualizar</button>
                </template>

                </modal-component>
                <!--Fim do modal de atualização de Categoria-->
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
export default{
    data(){
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/categorias',
            urlPaginacao: '',
            urlFiltro: '',
            idCategoria: '',
            nomeCategoria: '',
            categorias: [],
            //categoriasDados é necessário devido à maneira que a paginação é feita
            categoriasDados: [],
            busca:{
                id: '',
                nome: '',
            },
            transacaoDetalhes: {},
        }
    },
    methods:{
        buscarCategoria(){
            let filtro = '';

            for(let chave in this.busca){
                if(this.busca[chave]){
                    if(filtro != ''){
                        //condição atendida adicionará um ; para separar as consultas com múltiplos filtros
                        filtro += ';';
                    }
                    filtro += chave + ':like:' + this.busca[chave] + '%';
                }
            }
            if(filtro != ''){
                this.urlPaginacao = 'page=1';
                this.urlFiltro = '&filtro=' + filtro;
            }else{
                this.urlFiltro = '';
            }

            this.carregarLista();
        },
        salvar(){
            let formData = new FormData();

            formData.append('nome', this.nomeCategoria);

            let config = {
                'Accept' : 'application/json',
            }

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.carregarLista();
                    this.$store.state.transacao.status = 'sucesso'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do Registro: ' + response.data.id
                    };
                })
                .catch(errors => {
                    //console.log(errors)
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors
                    this.transacaoDetalhes = {
                        dados: errors.response.data.errors
                    }
                })
        },
        paginacao(l){
            if(l.url){
                this.urlPaginacao = l.url.split('?')[1];
                this.carregarLista();
            }
        },
        carregarLista(){
            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

            axios.get(url).then(response => {
                //console.log(response);
                this.categorias = response.data;
                this.categoriasDados = this.categorias.data;
            }).catch(errors => console.log(errors))
        },
        atualizar(){
            let formData = new FormData();

            formData.append('_method', 'patch');

            formData.append('nome', this.$store.state.item.nome);

            let url = this.urlBase + '/' + this.$store.state.item.id;

            let config = {
                headers: {
                    'Accept' : 'application/json'
                }
            }

            axios.post(url, formData, config)
                .then(response =>{
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro atualizado com sucesso!'
                    this.$store.state.transacao.dados = ''
                    //this.transacaoDetalhes = ''
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors
                    this.transacaoDetalhes = {
                        dados: errors.response.data.errors
                    }
                })
        },
        remover(){
            let confirmacao = confirm('Tem certeza que deseja remover essa categoria? Produtos relacionados serão movidos para a categoria Outros.');

            if(!confirmacao){
                return false;
            }

            let url = this.urlBase + '/' + this.$store.state.item.id;
            let formData = new FormData();

            formData.append('_method', 'delete');

            let config = {
                headers: {
                    'Accept' : 'application/json',
                    'Authorization' : this.token
                }
            }

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso',
                    this.$store.state.transacao.mensagem = 'Registro removido com sucesso',
                    this.urlPaginacao = 'page=1',
                    this.carregarLista()
                }).catch(errors => {
                    this.$store.state.transacao.status = 'erro',
                    this.$store.state.transacao.mensagem = 'Erro ao remover o registro',
                    this.$store.state.transacao.dados = errors.response.data.errors
                    this.transacaoDetalhes = {
                        dados: errors.response.data.errors
                    }
                })
        },
        limparCampos(){
            this.$store.state.transacao.status = '';
            this.nomeCategoria = '';
            this.transacaoDetalhes = '';
            this.$store.state.transacao.dados = '';
        },
    },
    mounted(){
        this.carregarLista();
    }
}

</script>