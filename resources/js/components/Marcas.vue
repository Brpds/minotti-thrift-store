<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                                <div class="col mb-3">
                                    <input-container id="inputId" titulo="ID" id-help="idHelp"
                                        texto-ajuda="Opcional. Informe o ID da Marca:"
                                    >
                                        <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID"
                                        v-model="busca.id">
                                    </input-container>
                                </div>
                                <div class="col mb-3">
                                    <input-container id="inputNome" titulo="Nome da Marca" id-help="nomeHelp"
                                        texto-ajuda="Opcional. Informe o nome da Marca"
                                    >
                                        <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da Marca"
                                        v-model="busca.nome">
                                    </input-container>
                                </div>
                            </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary float-end" @click="buscarMarca()">Buscar</button>
                    </template>
                </card-component>
                <card-component titulo="Lista de Marcas">
                    <template v-slot:conteudo>
                        <table-component 
                        :dados="marcasDados"
                        :ver="{
                            visivel: true,
                            dataToggle:'modal',
                            dataTarget:'#modalMarcaVer'
                        }"
                        :editar="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalMarcaAtualizar'
                        }"
                        :excluir="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalMarcaRemover'
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
                                    <li v-for="l, key in marcas.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'">
                                      <a class="page-link" v-html="l.label" @click="paginacao(l)">
                                        
                                      </a>
                                    </li>
                                </pagination-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalMarca"
                                >Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!--Lista de marcas fim-->

                <!--Início do modal de inclusão de marca-->
                <modal-component id="modalMarca" titulo="Adicionar Marca">

                    <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container id="novoMarca" titulo="Nome da Marca" id-help="novoMarcaHelp"
                                        texto-ajuda="Informe o nome da Marca"
                                    >
                            <input type="text" class="input-patina" id="novoMarca" aria-describedby="novoMarcaHelp" placeholder="Nome da Marca" v-model="nomeMarca">
                        </input-container>
                    </div>

                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </template>

                </modal-component>
                <!--Fim do modal de inclusão de marca-->

                <!--Início do modal de Ver de marca-->
                <modal-component id="modalMarcaVer" titulo="Ver Marca">
                    <template v-slot:conteudo>
                        <input-container titulo="ID">
                            <input type="text" class="input-patina" :value="$store.state.item.id" disabled>
                        </input-container>
                        <input-container titulo="Nome da Marca">
                            <input type="text" class="input-patina" :value="$store.state.item.nome" disabled>
                        </input-container>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </template>
                </modal-component>
                <!--Fim do modal de Ver de marca-->

                <!--Início do modal de Remover de marca-->
                <modal-component id="modalMarcaRemover" titulo="Remover Marca">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    </template>
                </modal-component>
                <!--Fim do modal de Remover de marca-->

                <!--Início do modal de atualização de marca-->
                <modal-component id="modalMarcaAtualizar" titulo="Atualizar Marca">

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
                <div class="form-group">
                    <input-container id="atualizarMarca" titulo="Nome da Marca" id-help="atualizarMarcaHelp"
                                    texto-ajuda="Informe o nome da Marca"
                                >
                        <input type="text" class="input-patina" id="atualizarMarca" aria-describedby="atualizarMarcaHelp" placeholder="Nome da Marca" v-model="$store.state.item.nome">
                    </input-container>
                </div>

                </template>

                <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </template>

                </modal-component>
                <!--Fim do modal de atualização de marca-->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/marcas',
            urlPaginacao: '',
            urlFiltro: '',
            nomeMarca: '',
            marcaId: '',
            marcas: [],
            //marcasDados é necessário devido à maneira que a paginação é feita
            marcasDados: [],
            busca: {
                id: '',
                nome: ''
            }
        }
    },
    methods:{
        buscarMarca(){
            //console.log(this.busca)

            let filtro = ''

            for(let chave in this.busca){
                if(this.busca[chave]){
                    //console.log(chave, this.busca[chave])
                    if(filtro != ''){
                        //condição adicionará um ; para separar as consultas com múltiplos filtros
                        filtro += ';'
                    }
                    filtro += chave + ':like:%' + this.busca[chave] + '%'
                }
            }
            if(filtro != ''){
                this.urlPaginacao = 'page=1'
                this.urlFiltro = '&filtro=' + filtro
            }else{
                this.urlFiltro = ''
            }

            this.carregarLista()
        },
        atualizar(){

            let formData = new FormData();

            formData.append('_method', 'patch')

            formData.append('nome', this.$store.state.item.nome)

            let url = this.urlBase + '/' + this.$store.state.item.id

            let config = {
                headers:{
                    'Content-Type' : 'multipart/form-data',
                    'Accept' : 'application/json',
                }
            }

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro atualizado com sucesso!'
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = 'Erro ao tentar atualizar o registro.'
                })
        },
        remover(){
            let confirmacao = confirm('Tem certeza que deseja remover essa marca? Produtos pertencentes a ela irão para a marca Outros.')

            if(!confirmacao){
                return false
            }
            let url = this.urlBase + '/' + this.$store.state.item.id
            let formData = new FormData();

            formData.append('_method', 'delete')

            //console.log(this.$store.state.transacao);

            let config = {
                headers: {
                    'Accept' : 'application/json',
                    'Authorization' : this.token
                }
            }
            
            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro removido com sucesso!'
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = 'Erro ao tentar remover o registro.'
                })
        },
        paginacao(l){
            if(l.url){
                //this.urlBase = l.url //ajustando a url com o parâmetro de página

                //ajustando a url dinamicamente para que a paginação seja adicionada de modo programático na url da requisição
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista() //carregando a lista com a paginação ajustada
            }
        },
        carregarLista(){

            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
            .then(response => {
                this.marcas = response.data
                this.marcasDados = this.marcas.data
            })
            .catch(errors => console.log(errors))
        },
        salvar(){

            let formData = new FormData();

            formData.append('nome', this.nomeMarca);
            
            let config = {
                headers:{
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            };

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.carregarLista()
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro adicionado com sucesso!'
                })
                .catch(errors => {
                    console.log(errors)
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = 'Erro ao tentar adicionar o registro.'
                })
        }
    },
    mounted(){
        this.carregarLista();
    }
}
</script>

<style>

</style>