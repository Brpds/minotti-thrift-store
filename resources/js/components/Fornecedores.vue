<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Busca de Fornecedores">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container id="inputCpf" titulo="CPF" id-help="cpfHelp"
                                        texto-ajuda="Opcional. Informe o CPF do Fornecedor sem '.' ou '-'"
                                >
                                    <input type="text" class="form-control" aria-describedby="cpfHelp" placeholder="000.000.000-00"
                                    v-model="busca.cpf">
                            </input-container>
                            </div>
                            <div class="col mb-3">
                                <input-container id="inputNome" titulo="Nome" id-help="nomeHelp"
                                        texto-ajuda="Opcional. Informe o Nome do Fornecedor"
                                >
                                <input type="text" class="form-control" aria-describedby="nomeHelp" placeholder="Fornecedor"
                                v-model="busca.nome" >
                            </input-container>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary float-end" @click="buscarFornecedor()">Buscar</button>
                    </template>
                </card-component>
                <card-component titulo="Lista de Fornecedores">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="fornecedoresDados"
                            :ver="{
                                visivel: true,
                                dataToggle:'modal',
                                dataTarget:'#modalFornecedorVer',
                                onVer:() => editarFornecedorCarregarInfo()
                            }"
                            :editar="{
                                visivel:true,
                                dataToggle:'modal',
                                dataTarget:'#modalFornecedorAtualizar',
                                onEditar:() => editarFornecedorCarregarInfo()
                            }"
                            :excluir="{
                                visivel:true,
                                dataToggle:'modal',
                                dataTarget:'#modalFornecedorRemover'
                            }"
                            :titulos="{
                                id:{titulo: 'ID', tipo:'text'},
                                nome:{titulo: 'Nome', tipo:'text'},
                                cpf:{titulo:'CPF', tipo:'text'}
                            }"
                        ></table-component>
                    </template>
                    <template v-slot:rodape>
                        <pagination-component>
                            <li v-for="l, key in fornecedores.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'">
                                <a class="page-link" v-html="l.label" @click="paginacao(l)">
                                  
                                </a>
                            </li>
                        </pagination-component>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalFornecedor">Adicionar</button>
                    </template>
                </card-component>

                <!--Início do modal de inclusão de Fornecedor-->
                <modal-component id="modalFornecedor" titulo="Adicionar Fornecedor">
                    <template v-slot:alertas>
                        <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="this.$store.state.transacao.status == 'sucesso'"></alert-component>
                        <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o fornecedor." v-if="this.$store.state.transacao.status == 'erro'"></alert-component>
                    </template>
                    <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                    <div class="form-group">
                        <input-container id="novoFornecedor" titulo="Nome do Fornecedor" id-help="novoFornecedorHelp"
                                        texto-ajuda="Informe o nome do Fornecedor"
                                    >
                            <input type="text" class="form-control" id="novoFornecedor" aria-describedby="novoFornecedorHelp" placeholder="Nome do Fornecedor" v-model="nomeFornecedor">
                        </input-container>
                    </div>

                    <!--
                        <div class="form-group">
                            <input-container id="inputImagem" titulo="Imagem" id-help="inputImagemHelp"
                                texto-ajuda="Insira uma Imagem PNG"
                            >
                                <input type="file" class="form-control" id="inputImagem" aria-describedby="inputImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
                            </input-container>
                        </div>
                    -->

                    <div class="form-group">
                        <input-container id="inputCPF" titulo="CPF" id-help="inputCPF"
                            texto-ajuda="CPF"
                        >
                            <input type="text" class="form-control" id="inputCPF" aria-describedby="inputCPFHelp" placeholder="CPF do Fornecedor"
                            v-model="cpfFornecedor">
                        </input-container>
                    </div>
                
                    <div class="form-group">
                        <input-container id="inputEndereco" titulo="Endereço" id-help="inputEnderecoHelp"
                        texto-ajuda="Endereço do Fornecedor"
                        >
                            <input type="text-area" class="form-control" id="inputEndereco" aria-describedby="inputEnderecoHelp" placeholder="Endereço do Fornecedor"
                            v-model="enderecoFornecedor">
                        </input-container>
                    </div>

                    <div class="form-group">
                        <input-container id="inputNumero" titulo="Número" id-help="inputNumeroHelp"
                        texto-ajuda="Número"
                        >
                            <input type="text-area" class="form-control" id="inputNumero" aria-describedby="inputEnderecoHelp" placeholder="Número"
                            v-model="numeroCasaFornecedor">
                        </input-container>
                    </div>

                    <div class="form-group">
                        <input-container id="inputCep" titulo="CEP" id-help="inputCEPHelp"
                        texto-ajuda="CEP do Fornecedor"
                        >
                            <input type="text-area" class="form-control" id="inputCEP" aria-describedby="inputCEPHelp" placeholder="CEP do Fornecedor"
                            v-model="cepFornecedor">
                        </input-container>
                    </div>

                    <div class="form-group">
                        <input-container id="inputReferencia" titulo="Ponto de Referência" id-help="inputReferenciaHelp"
                        texto-ajuda="Ponto de Referência"
                        >
                            <input type="text-area" class="form-control" id="inputReferencia" aria-describedby="inputReferenciaHelp" placeholder="Ponto de Referência"
                            v-model="referenciaEnderecoFornecedor">
                        </input-container>
                    </div>
                
                    <div class="form-group">
                        <input-container id="inputTelefone" titulo="Telefone" id-help="inputTelefoneHelp"
                        texto-ajuda="Telefone do Fornecedor"
                        >
                            <input type="tel" class="form-control" id="inputTelefone" aria-describedby="inputTelefoneHelp" placeholder="(00) 00000 - 0000"
                            v-model="telefoneFornecedor">
                        </input-container>
                    </div>
                    
                    <div class="form-group">
                        <input-container id="inputChavePix" titulo="Chave Pix" id-help="inputChavePixHelp"
                        texto-ajuda="Chave Pix do Fornecedor"
                        >
                            <input type="text" class="form-control" id="inputChavePix" aria-describedby="inputChavePixHelp" placeholder="Chave Pix do Fornecedor"
                            v-model="chave_pixFornecedor">
                        </input-container>
                    </div>
                </template>

                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                    <button type="button" class="btn btn-primary" @click="salvar()" v-if="$store.state.transacao.status != 'sucesso'">Salvar</button>
                </template>

                </modal-component>
                <!--Fim do modal de inclusão de Fornecedor-->

                <!--Início do modal de Ver de Fornecedor-->
                <modal-component id="modalFornecedorVer" titulo="Ver Fornecedor">
                    <template v-slot:conteudo>
                        <input-container titulo="ID">
                            <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                        </input-container>
                        <input-container titulo="Nome do Fornecedor">
                            <input type="text" class="form-control" :value="$store.state.item.nome || 'Não Informado'" disabled>
                        </input-container>
                        <div class="form-group">
                    <input-container id="inputCPF" titulo="CPF" id-help="inputCPF"
                        texto-ajuda="CPF"
                    >
                        <input type="text" class="form-control" id="inputCPF" aria-describedby="inputCPFHelp" placeholder="CPF do Fornecedor"
                        :value="$store.state.activeItem.cpf || 'Não Informado'" disabled>
                    </input-container>
                </div>
                
                <div class="form-group">
                    <input-container id="inputEndereco" titulo="Endereço" id-help="inputEnderecoHelp"
                    texto-ajuda="Endereço do Fornecedor"
                    >
                        <input type="text-area" class="form-control" id="inputEndereco" aria-describedby="inputEnderecoHelp" placeholder="Endereço do Fornecedor"
                        :value="$store.state.activeItem.endereco || 'Não Informado'" disabled>
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputNumero" titulo="Número" id-help="inputNumeroHelp"
                    texto-ajuda="Número"
                    >
                        <input type="text-area" class="form-control" id="inputNumero" aria-describedby="inputEnderecoHelp" placeholder="Número"
                        :value="$store.state.activeItem.numero || 'Não Informado'" disabled>
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputCep" titulo="CEP" id-help="inputCEPHelp"
                    texto-ajuda="CEP do Fornecedor"
                    >
                        <input type="text-area" class="form-control" id="inputCEP" aria-describedby="inputCEPHelp" placeholder="CEP do Fornecedor"
                        :value="$store.state.activeItem.cep || 'Não Informado'" disabled>
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputReferencia" titulo="Ponto de Referência" id-help="inputReferenciaHelp"
                    texto-ajuda="Ponto de Referência"
                    >
                        <input type="text-area" class="form-control" id="inputReferencia" aria-describedby="inputReferenciaHelp" placeholder="Ponto de Referência"
                        :value="$store.state.activeItem.referencia || 'Não Informado'" disabled>
                    </input-container>
                </div>
                
                <div class="form-group">
                    <input-container id="inputTelefone" titulo="Telefone" id-help="inputTelefoneHelp"
                    texto-ajuda="Telefone do Fornecedor"
                    >
                        <input type="tel" class="form-control" id="inputTelefone" aria-describedby="inputTelefoneHelp" placeholder="(00) 00000 - 0000"
                        :value="$store.state.activeItem.telefone || 'Não Informado'" disabled>
                    </input-container>
                </div>
                    
                <div class="form-group">
                    <input-container id="inputChavePix" titulo="Chave Pix" id-help="inputChavePixHelp"
                    texto-ajuda="Chave Pix do Fornecedor"
                    >
                        <input type="text" class="form-control" id="inputChavePix" aria-describedby="inputChavePixHelp" placeholder="Chave Pix do Fornecedor"
                        :value="$store.state.activeItem.chave_pix || 'Não Informado'" disabled>
                    </input-container>
                </div>

                </template>
                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </template>
                </modal-component>
                <!--Fim do modal de Ver Fornecedor-->

                <!--Início do modal de Remover de Fornecedor-->
                <modal-component id="modalFornecedorRemover" titulo="Remover Fornecedor">
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
                        <input-container titulo="Nome do Fornecedor">
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                        </input-container>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    </template>
                </modal-component>
                <!--Fim do modal de Remover de Fornecedor-->

                <!--Início do modal de atualização de Fornecedor-->
                <modal-component id="modalFornecedorAtualizar" titulo="Atualizar Fornecedor">

                    <template v-slot:alertas>
                        <alert-component
                         tipo="success" titulo="Operação realizada com sucesso!" :detalhes="this.$store.state.transacao"
                         v-if="$store.state.transacao.status == 'sucesso'"
                        >
                        </alert-component>
                        <alert-component
                         tipo="danger" titulo="Erro ao tentar atualizar o registro." :detalhes="transacaoDetalhes"
                         v-if="$store.state.transacao.status == 'erro'"
                        >
                        </alert-component>
                    </template>

                <template v-slot:conteudo v-if="this.$store.state.transacao.status != 'sucesso'">
                <div class="form-group">
                    <input-container id="atualizarFornecedor" titulo="Nome do Fornecedor" id-help="atualizarFornecedor1Help"
                                    texto-ajuda="Informe o nome do Fornecedor"
                                >
                        <input type="text" class="form-control" id="atualizarFornecedor" aria-describedby="atualizarFornecedorHelp" placeholder="Nome do Fornecedor" v-model="$store.state.activeItem.nome">
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputCPF" titulo="CPF" id-help="inputCPF"
                        texto-ajuda="CPF"
                    >
                        <input type="text" class="form-control" id="inputCPF" aria-describedby="inputCPFHelp" placeholder="CPF do Fornecedor"
                        v-model="$store.state.activeItem.cpf">
                    </input-container>
                </div>
                
                <div class="form-group">
                    <input-container id="inputEndereco" titulo="Endereço" id-help="inputEnderecoHelp"
                    texto-ajuda="Endereço do Fornecedor"
                    >
                        <input type="text-area" class="form-control" id="inputEndereco" aria-describedby="inputEnderecoHelp" placeholder="Endereço do Fornecedor"
                        v-model="$store.state.activeItem.endereco">
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputNumero" titulo="Número" id-help="inputNumeroHelp"
                    texto-ajuda="Número"
                    >
                        <input type="text-area" class="form-control" id="inputNumero" aria-describedby="inputEnderecoHelp" placeholder="Número"
                        v-model="$store.state.activeItem.numero">
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputCep" titulo="CEP" id-help="inputCEPHelp"
                    texto-ajuda="CEP do Fornecedor"
                    >
                        <input type="text-area" class="form-control" id="inputCEP" aria-describedby="inputCEPHelp" placeholder="CEP do Fornecedor"
                        v-model="$store.state.activeItem.cep">
                    </input-container>
                </div>

                <div class="form-group">
                    <input-container id="inputReferencia" titulo="Ponto de Referência" id-help="inputReferenciaHelp"
                    texto-ajuda="Ponto de Referência"
                    >
                        <input type="text-area" class="form-control" id="inputReferencia" aria-describedby="inputReferenciaHelp" placeholder="Ponto de Referência"
                        v-model="$store.state.activeItem.referencia">
                    </input-container>
                </div>
                
                <div class="form-group">
                    <input-container id="inputTelefone" titulo="Telefone" id-help="inputTelefoneHelp"
                    texto-ajuda="Telefone do Fornecedor"
                    >
                        <input type="tel" class="form-control" id="inputTelefone" aria-describedby="inputTelefoneHelp" placeholder="(00) 00000 - 0000"
                        v-model="$store.state.activeItem.telefone">
                    </input-container>
                </div>
                    
                <div class="form-group">
                    <input-container id="inputChavePix" titulo="Chave Pix" id-help="inputChavePixHelp"
                    texto-ajuda="Chave Pix do Fornecedor"
                    >
                        <input type="text" class="form-control" id="inputChavePix" aria-describedby="inputChavePixHelp" placeholder="Chave Pix do Fornecedor"
                        v-model="$store.state.activeItem.chave_pix">
                    </input-container>
                </div>

                <!--<div class="form-group">
                    <input-container id="inputAtualizarImagem" titulo="Imagem" id-help="inputImagemHelp"
                                    texto-ajuda="Insira uma Imagem PNG"
                                >
                        <input type="file" class="form-control" id="inputAtualizarImagem" aria-describedby="inputImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
                    </input-container>
                </div> -->
                </template>

                <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()" v-if="this.$store.state.transacao.status != 'sucesso'">Atualizar</button>
                </template>

                </modal-component>
                <!--Fim do modal de atualização de Fornecedor-->


            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data(){
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/fornecedores',
            nomeFornecedor: '',
            cpfFornecedor: '',
            enderecoFornecedor:'',
            numeroCasaFornecedor:'',
            cepFornecedor:'',
            referenciaEnderecoFornecedor:'',
            telefoneFornecedor: '',
            chave_pixFornecedor: '',
            urlPaginacao: '',
            urlFiltro: '',
            fornecedores: [],
            fornecedoresDados: [],
            busca:{
                cpf: '',
                nome: ''
            },
            transacaoDetalhes: '',
        }
    },
    methods:{
        atualizar(){
            console.log(this.$store.state.activeItem)
            const formData = new FormData();

            formData.append('_method', 'patch');

            formData.append('nome', this.$store.state.activeItem.nome);
            formData.append('cpf', this.$store.state.activeItem.cpf);
            formData.append('endereco', this.$store.state.activeItem.endereco);
            formData.append('telefone', this.$store.state.activeItem.telefone);
            formData.append('chave_pix', this.$store.state.activeItem.chave_pix);
            formData.append('numero', this.$store.state.activeItem.numero);
            formData.append('cep', this.$store.state.activeItem.cep);
            formData.append('referencia', this.$store.state.activeItem.referencia);

            let config = {
                'Accept' : 'application/json',
                'Content-Type' : 'multipart/form-data'
            }

            let url = this.urlBase + '/' + this.$store.state.activeItem.id;

            axios.post(url, formData, config)
                .then(response =>{
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro atualizado com sucesso!'
                    this.$store.state.transacao.dados = ''
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
        async editarFornecedorCarregarInfo(){
            try{
                //esta função se encarregará de carregar os dados numa mutation da $store para acesso no modal de edição
                const response = await axios.get(this.urlBase + '/' + this.$store.state.item.id);
                this.$store.commit('setActiveItem', response.data)
                console.log(this.$store.state.activeItem);
                //console.log(response.data)
            }catch(errors){
                console.log(errors)
            }
            
        },
        remover(){
            let confirmacao = confirm('Deseja remover o fornecedor? Os produtos relacionados serão adicionados para um perfil da Loja.')

            if(!confirmacao){
                return false;
            }
            let url = this.urlBase + '/' + this.$store.state.item.id

            let formData = new FormData();

            formData.append('_method', 'delete')

            let config = {
                'Accept' : 'application/json',
                'Authorization' : this.token
            }

            axios.post(url, formData, config)
                .then(response =>{
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Fornecedor removido com sucesso! Os produtos foram adicionados para um perfil do Brechó.'
                    this.p
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = 'Erro ao tentar remover o fornecedor.'
                })
        },
        salvar(){
            /*let formData = {
                
                nome: this.nomeFornecedor,
                cpf: this.cpfFornecedor,
                endereco: this.enderecoFornecedor,
                telefone: this.telefoneFornecedor,
                chave_pix: this.chave_pixFornecedor,
                numero: this.numeroCasaFornecedor,
                cep: this.cepFornecedor,
                referencia: this.referenciaEnderecoFornecedor,

            }*/

            let formData = new FormData();

            formData.append('nome', this.nomeFornecedor);
            formData.append('cpf', this.cpfFornecedor);
            formData.append('endereco', this.enderecoFornecedor);
            formData.append('telefone', this.telefoneFornecedor);
            formData.append('chave_pix', this.chave_pixFornecedor);
            formData.append('numero', this.numeroCasaFornecedor);
            formData.append('cep', this.cepFornecedor);
            formData.append('referencia', this.referenciaEnderecoFornecedor);

            //console.log(formData)

            let config = {
                headers:{
                    'Content-Type' : 'multipart/form-data',
                    'Accept' : 'application/json'
                }
            };

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.carregarLista()
                    this.$store.state.transacao.status = 'sucesso'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do Registro: ' + response.data.id
                    };
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
        buscarFornecedor(){
            let filtro = ''

            for(let chave in this.busca){
                if(this.busca[chave]){
                    //console.log(chave, this.busca[chave])
                    if(filtro != ''){
                        filtro += ';'
                    }
                    filtro += chave + ':like:' + this.busca[chave] + '%'
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
        paginacao(l){
            if(l.url){
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista()
            }
        },
        carregarLista(){

            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
            
            axios.get(url)
                .then(response => {
                    this.fornecedores = response.data
                    this.fornecedoresDados = this.fornecedores.data
                    //console.log(this.fornecedores)
                })
                .catch(errors => console.log(errors))
        },
        limparCampos(){
            this.$store.state.transacao.status = '';
            this.transacaoDetalhes = '';
            this.$store.state.transacao.dados = '';
            this.nomeFornecedor = '';
            this.cpfFornecedor = '';
            this.enderecoFornecedor = '';
            this.telefoneFornecedor = '';
            this.chave_pixFornecedor = '';
            this.numeroCasaFornecedor = '';
            this.cepFornecedor = '';
            this.referenciaEnderecoFornecedor = '';
        },
    },
    mounted(){
        this.carregarLista();
    },
}
</script>

<style>

</style>