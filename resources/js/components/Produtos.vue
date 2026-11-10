<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--card buscas início-->
                <card-component titulo="Busca de Produtos">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container id="inputEtiqueta" titulo="Código" id-help="etiquetaHelp"
                                    texto-ajuda="Opcional. Informe o código do produto:"
                                >
                                    <input type="text" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Código"
                                        v-model="busca.etiqueta"
                                    >
                                </input-container>
                            </div>
                            <div class="col mb-3">
                                <input-container id="inputNome" titulo="Nome do Produto" id-help="nomeHelp"
                                    texto-ajuda="Opcional. Informe o nome do produto"
                                >
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do Produto"
                                        v-model="busca.nome"
                                    >
                                </input-container>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary float-end" @click="buscarProduto()">Buscar</button>
                    </template>
                </card-component>
                <!--card buscas fim-->
                
                <!--Lista de produtos início-->
                <card-component titulo="Lista de Produtos">
                    <template v-slot:conteudo>
                        <table-component
                        :dados="produtosDados"
                        :ver="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalProdutoVer',
                            onVer: () => editarVerProdutoCarregarInfo()
                        }"
                        :editar="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalProdutoEditar',
                            onEditar: () => editarVerProdutoCarregarInfo()
                        }"
                        :excluir="{
                            visivel:true,
                            dataToggle:'modal',
                            dataTarget:'#modalProdutoRemover',
                            onRemover: () => editarVerProdutoCarregarInfo()
                            }"
                        :titulos="{
                            etiqueta:{titulo: 'Etiqueta', tipo: 'text'},
                            imagem: {titulo: 'Imagem', tipo:'imagem'},
                            nome:{titulo: 'Nome', tipo: 'text'},
                            valor_venda:{titulo: 'Preço', tipo: 'number'},
                            status: {titulo: 'Status', tipo:'text'},
                            id:{titulo: 'ID', tipo: 'text'},
                        }"
                        :srcUrlPath="srcUrlPath"
                        ></table-component>
                    </template>
                    <template v-slot:rodape>
                        <pagination-component>
                            <li v-for="l, key in produtos.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'">
                                <a class="page-link" v-html="l.label" @click="paginacao(l)">

                                </a>
                            </li>
                        </pagination-component>
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalProduto" @click="limparStatus()"
                        >Adicionar</button>
                    </template>
                </card-component>
                <!--Lista de produtos fim-->

                <!--Início Modal de inclusão de produtos-->
                <modal-component id="modalProduto" titulo="Adicionar Produto">
                    <template v-slot:alertas>
                        <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                        <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o Produto." v-if="transacaoStatus == 'erro'"></alert-component>
                    </template>
                    <template v-slot:conteudo v-if="this.transacaoStatus != 'adicionado'">
                        <div class="form-group">
                            
                            <imgsubmit-component v-model="imagemProduto" />

                            <!--
                                <input-container id="inputImagem" titulo="Imagem" id-help="inputImagemHelp"
                                texto-ajuda="Insira uma Imagem PNG">
                                <img 
                                v-if="previewUrl"
                                :src="previewUrl"
                                alt="Prévia da Imagem"
                                style="max-width: 200px; margin-top: 10px; border-radius: 6px;"
                                >
                                
                                <input type="file" ref="inputImagem" class="form-control" accept="image/png, image/jpg" id="inputImagem" aria-describedby="inputImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
                            </input-container>
                            -->

                            <input-container id="inputNome" titulo="Nome" id-help="inputNomeHelp"
                                texto-ajuda="">

                                <input type="text" class="input-patina" id="inputNome" aria-describedby="inputImagemHelp" placeholder="Nome do Produto" v-model="nomeProduto">
                            </input-container>

                            <input-container id="inputDescricao" titulo="Descrição" id-help="inputDescricaoHelp"
                                        texto-ajuda=""
                                    >
                            <textarea class="textarea-patina" rows="4" placeholder="Escreva um pouco sobre a peça..." v-model="descricaoProduto"></textarea>
                            </input-container>

                            <input-container id="inputCondicaoProduto" titulo="Condição do Produto" id-help="inputCondicaoProdutoHelp"
                                            texto-ajuda=""
                                        >
                                <select-component id="condicao_produto" route-name="opcoes/condicao" v-model="condicaoProduto"></select-component>
                            </input-container>
                        
                            <multi-select
                               api-url="fornecedores/list"
                               v-model="fornecedorProduto"
                               label="Fornecedor"
                            />

                            <multi-select
                               api-url="categorias/list"
                               v-model="categoriaProduto"
                               label="Categoria"
                            />                                    

                            <multi-select
                               api-url="marcas/list"
                               v-model="marcaProduto"
                               label="Marca"
                            />

                            <!--
                                O componente só será exibido com os respectivos IDs de roupas ou calçados.
                                Verificar no DB qual o ID correspondente das duas categorias para correta edição,
                                garantindo que funcione.
                            -->
                            <input-container v-if="categoriaProduto.id == '2'" id="inputTamanho" titulo="Tamanho do Calçado" id-help="inputTamanho" texto-ajuda="Tamanho">
                                <select-component id="tamanho" route-name="tamanhocalcado" v-model="tamanho">

                                </select-component>                            
                            </input-container>

                            <input-container v-if="categoriaProduto.id =='3'" id="inputTamanho" titulo="Tamanho da Roupa" id-help="inputTamanho" texto-ajuda="Tamanho">
                                <select-component id="tamanho" route-name="tamanhoroupa" v-model="tamanho">

                                </select-component>
                            </input-container>
                        
                            <input-container id="inputValorVenda" titulo="" id-help="inputValorVendaHelp"
                                texto-ajuda=""
                            >
                                <!--
                                    <price-input v-model=valorVendaProduto></price-input>
                                -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1" for="valor_venda">Valor de Venda</label>
                                        <input class="text-right w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" id="valor_venda" min="0" :value="formattedPrice" @input="handlePriceInput" placeholder="" type="text"/>
                                    </div>

                            </input-container>
                        
                            <input-container id="inputDivisao" titulo="Divisão" id-help="inputDivisaomHelp"
                                            texto-ajuda=""
                                        >
                                <select-component id="tipo_divisao" route-name="opcoes/divisao" v-model="tipoDivisaoProduto"></select-component>
                            </input-container>

                            <div v-if="tipoDivisaoProduto == 'percentual'">
                                <input-container id="inputPorcentagemLoja" titulo="Porcentagem da Loja: 10% - 50%" id-help="inputPorcentagemLoja"
                                    texto-ajuda="">
                                    <input type="range" class="" id="inputPorcentagemLoja" aria-describedby="inputPorcentagemLojaHelp"
                                        min="10" max="50" step="5" @change="parteLoja = (valorVendaProduto * porcentagemLoja)/100" v-model="porcentagemLoja"
                                    >
                                    {{ porcentagemLoja + '%'}}
                                </input-container>

                                <input-container id="inputParteLoja" titulo="" id-help="inputParteLojaHelp"
                                    texto-ajuda=""
                                >
                                    <!--
                                        <input type="number" class="form-control" disabled id="inputParteLoja" aria-describedby="inputParteLojaHelp" placeholder="R$ 0,00" :value="parteLoja">
                                    -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1" for="store_cut">Parte da Loja</label>
                                        <input class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium text-right" id="store_cut" min="0" :value="formattedStoreCut" @input="handleStoreCutInput" placeholder="" type="text"/>
                                    </div>
                                    
                            
                                </input-container>
                            </div>

                            <div v-if="tipoDivisaoProduto == 'fixo'">
                                <input-container id="inputParteLoja" titulo="" id-help="inputParteLojaHelp"
                                    texto-ajuda=""
                                >
                                    <!--
                                        <price-input v-model=parteLoja></price-input>
                                    -->
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1" for="store_cut">Parte da Loja</label>
                                        <input class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium text-right" id="store_cut" min="0" :value="formattedStoreCut" @input="handleStoreCutInput" placeholder="" type="text"/>
                                    </div>
                                
                                </input-container>
                            </div>

                            <input-container id="inputStatusProduto" titulo="Status Produto" id-help="inputStatusProdutoHelp"
                                        >
                                <select-component id="status_produto" route-name="opcoes/status" v-model=statusProduto></select-component>
                            </input-container>

                            <input-container id="inputEtiquetaProduto">
                                <label for="etiquetaProduto" class="block text-sm font-bold text-on-surface-variant ml-1">Etiqueta</label>
                                <input id="etiquetaProduto" class="text-left w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" type="text" v-model="etiquetaProduto" placeholder="AAA-000" />
                            </input-container>
                                                    
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="salvar()" v-if="this.transacaoStatus != 'adicionado'">Salvar</button>
                    </template>
                </modal-component>
                <!--Fim Modal de inclusão de produtos-->

                <!--Início Modal de Visualização de produtos-->
                <modal-component id="modalProdutoVer" titulo="Ver Produto">
                    <template v-slot:alertas>
                    </template>
                    <template v-slot:conteudo>
                        <div class="form-group">
                        
                            <input-container class="flex justify-center">

                                <img
                                    id="viewImageField"
                                    :src="srcUrlPath + $store.state.activeItem.imagem"
                                    alt="Imagem do Produto"
                                    style="max-width: 200px; margin-top: 10px; border-radius: 6px;"
                                    class="aspect-square rounded-lg bg-surface-variant flex flex-col items-center justify-center border-2 border-outline-variant/30 text-outline cursor-pointer hover:bg-surface-container-high transition-colors"
                                >

                                
                            </input-container>
                            <label for="imageField" class="block font-headline font-bold text-on-surface text-center">Cód.: {{$store.state.activeItem.etiqueta}}</label>

                            <input-container id="inputNome" titulo="Nome" id-help="inputNomeHelp"
                            >

                                <input type="text" class="input-patina" id="inputNome" aria-describedby="inputNomeHelp" :value="$store.state.activeItem.nome" disabled>
                            </input-container>

                            <input-container id="inputCondicaoProduto" titulo="Condição do Produto: " id-help="inputCondicaoProdutoHelp"
                                            texto-ajuda=""
                                        >
                                <input type="text" id="condicao_produto" class="input-patina" :value="$store.state.activeItem.condicao" disabled>
                            </input-container>

                            <input-container id="inputFornecedor" titulo="Nome do Fornecedor" id-help="inputFornecedorHelp">
                            
                                <input type="text" class="input-patina" id="inputFornecedor" aria-describedby="inputFornecedorHelp" :value="$store.state.activeItem.fornecedor?.nome" disabled>

                            </input-container>

                            <input-container id="inputCategoria" titulo="Categoria" id-help="inputCategoriaHelp">
                            
                                <input type="text" class="input-patina" id="inputCategoria" aria-describedby="inputCategoriaHelp" :value="$store.state.activeItem.categoria?.nome" disabled>

                            </input-container>                         

                            <input-container id="inputMarca" titulo="Marca" id-help="inputMarcaHelp">
                            
                                <input type="text" class="input-patina" id="inputMarca" aria-describedby="inputMarcaHelp" :value="$store.state.activeItem.marca?.nome" disabled>

                            </input-container>
                        
                            <input-container id="inputDescricao" titulo="Descrição" id-help="inputDescricaoHelp"
                            >

                                <textarea class="textarea-patina" :value="$store.state.activeItem.descricao" disabled></textarea>

                            </input-container>
                        
                            <input-container id="inputValorVenda" titulo="Valor de Venda" id-help="inputValorVendaHelp">

                                <price-input class="input-patina" :value="`R$ `+formattedDisplayPrice($store.state.activeItem.valor_venda)" disabled></price-input>

                            </input-container>

                            <input-container id="inputTipoDivisao" titulo="Tipo de Divisão" id-help="inputTipoDivisaoHelp">
                            
                                <input type="text" class="input-patina" id="inputTipoDivisao" aria-describedby="inputTipoDivisaoHelp" :value="$store.state.activeItem.tipo_divisao" disabled>
                                
                            </input-container>

                            <input-container id="inputStatusProduto" titulo="Status do Produto" id-help="inputStatusProdutoHelp">
                            
                                <input type="text" class="input-patina" id="inputStatusProduto" aria-describedby="inputStatusProdutoHelp" :value="$store.state.activeItem.status" disabled>
                                
                            </input-container>

                            <input-container id="inputParteDaLoja" titulo="Parte da Loja" id-help="inputParteDaLojaHelp" >
                            
                                <input type="text" class="input-patina" id="inputParteLoja" aria-describedby="inputParteLojaHelp" :value="`R$ `+formattedDisplayPrice($store.state.activeItem.parte_loja)" disabled>
                                
                            </input-container>
                                                    
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                    </template>
                </modal-component>
                <!--Fim Modal de Visualização de produtos-->

                <!--Início Modal de Edição de produtos-->
                <modal-component id="modalProdutoEditar" titulo="Editar Produto">
                    <template v-slot:alertas>
                        <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Alterado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                        <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar alterar o Produto." v-if="transacaoStatus == 'erro'"></alert-component>
                    </template>
                    <template v-slot:conteudo>
                        <div class="form-group">
                            <input-container id="inputAtualizarImagem" titulo="" id-help="inputImagemHelp">
                            <div class="col-span-full md:col-span-2 md:col-start-2 aspect-square rounded-lg bg-twprimary flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/30 text-outline cursor-pointer hover:bg-surface-container-high transition-colors">

                                <img 
                                v-if="$store.state.activeItem.imagem"
                                :src="srcUrlPath + $store.state.activeItem.imagem"
                                alt="Imagem Anterior"
                                class="w-full h-full object-cover rounded-lg"
                                id="currentImg"
                                >
                                <label for="currentImg" class="block font-headline font-bold text-on-surface text-center">Imagem Atual</label>
                            </div>

                            <div @click="$refs.inputNovaImagem.click()" class="col-span-full md:col-span-2 md:col-start-2 mt-[24px] aspect-square rounded-lg bg-green-300 flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/30 text-outline cursor-pointer transition-colors">

                                <span class="material-symbols-outlined">
                                    flip_camera_ios
                                </span>
                                <img 
                                v-if="previewUrl"
                                :src="previewUrl"
                                alt="Prévia da Nova Imagem"
                                class="w-full h-full object-cover rounded-lg"
                                >
                                
                                <input type="file" hidden ref="inputNovaImagem" class="form-control" accept="image/png, image/jpg" id="inputAtualizarImagem" aria-describedby="inputImagemHelp" @change="carregarImagem($event)">
                                <label for="currentImg" class="block font-headline font-bold text-on-surface text-center">Nova Imagem</label>
                                <span v-if="previewUrl" @click="clearImgPreview()" class="material-symbols-outlined block text-center cursor-pointer">
                                    delete
                                </span>
                            </div>
                            </input-container>

                            <input-container id="inputNomeAtual" titulo="Nome Atual do Produto" id-help="inputNomeHelp"
                                texto-ajuda="">

                                <input type="text" class="input-patina bg-yellow-200" id="inputNome" aria-describedby="inputNomeHelp" :value="item.nome" disabled>

                            </input-container>

                            <input-container id="inputNome" titulo="Novo Nome do Produto" id-help="inputNomeHelp">

                                <input type="text" class="input-patina" id="inputNome" aria-describedby="inputNomeHelp" v-model="nomeProduto">
                            </input-container>

                            

                            <input-container id="inputCondicaoProduto" titulo="Condição Atual do Produto" id-help="inputCondicaoHelp">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputCondicaoAtual" aria-describedby="inputFornecedorHelp" :value="item.condicao" disabled>

                            </input-container>

                            <input-container id="inputNovaCondicaoProduto" titulo="Nova Condição do Produto" id-help="inputNovaCondicaoProdutoHelp">
                                <select-component id="condicao_produto" route-name="opcoes/condicao" v-model="condicaoProduto"></select-component>
                            </input-container>
                                                  
                            
                            <input-container id="inputFornecedor" titulo="Nome do Fornecedor Atual" id-help="inputFornecedorHelp">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputFornecedorAtual" aria-describedby="inputFornecedorHelp" :value="item.fornecedor?.nome" disabled>

                            </input-container>

                            <multi-select
                               api-url="fornecedores/list"
                               v-model="fornecedorProduto"
                               label="Novo Fornecedor"
                            />

                            <input-container id="inputCategoria" titulo="Categoria Atual" id-help="inputCategoriaHelp">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputCategoriaAtual" aria-describedby="inputCategoriaHelp" :value="item.categoria?.nome" disabled>

                            </input-container>

                            <multi-select
                               api-url="categorias/list"
                               v-model="categoriaProduto"
                               label="Nova Categoria"
                            />

                            <input-container  id="inputTamanhoAtual" id-help="inputTamanhoAtual">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-on-surface-variant ml-1" for="tamanho_item">Tamanho Atual</label>
                                    <input id="tamanho_item" class="text-right w-full bg-yellow-200 border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" :value="item.tamanho ? item.tamanho : 'Único'" disabled type="text"/>
                                </div>
                            </input-container>

                            

                            <!--
                                O componente só será exibido com os respectivos IDs de roupas ou calçados.
                                Verificar no DB qual o ID correspondente das duas categorias para correta edição,
                                garantindo que funcione.
                            -->
                            <input-container v-if="categoriaProduto.id == '2'" id="inputNovoTamanho" titulo="Novo Tamanho do Calçado" id-help="inputTamanho">
                                <select-component id="tamanho" route-name="tamanhocalcado" v-model="tamanho">

                                </select-component>
                            </input-container>

                            <input-container v-if="categoriaProduto.id =='3'" id="inputNovoTamanho" titulo="Novo Tamanho da Roupa" id-help="inputTamanho">
                                <select-component id="tamanho" route-name="tamanhoroupa" v-model="tamanho">

                                </select-component>
                            </input-container>
                            
                            <input-container id="inputMarca" titulo="Marca Atual" id-help="inputMarcaHelp">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputMarcaAtual" aria-describedby="inputMarcaHelp" :value="item.marca?.nome" disabled>

                            </input-container>

                            <multi-select
                               api-url="marcas/list"
                               v-model="marcaProduto"
                               label="Nova Marca"
                            />
                        
                            <input-container id="inputDescricaoAtual" titulo="Descrição Atual" id-help="inputDescricaoHelp"
                            >

                                <textarea class="textarea-patina bg-yellow-200" :value="item.descricao" disabled></textarea>

                            </input-container>

                            <input-container id="inputDescricao" titulo="Nova Descrição" id-help="inputDescricaoHelp">

                                <textarea class="textarea-patina" v-model="descricaoProduto"></textarea>

                            </input-container>
                        
                            <input-container id="inputValorVendaAtual" titulo="Valor de Venda Atual" id-help="inputValorVendaAtualHelp"
                                
                            >
                                <input type="text" class="input-patina bg-yellow-200" :value="'R$ ' + formattedDisplayPrice(item.valor_venda)" disabled>

                            </input-container>

                            <input-container id="inputNovoValorVenda" id-help="inputNovoValorVendaHelp">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-on-surface-variant ml-1" for="valor_venda">Novo Valor de Venda</label>
                                    <input class="text-right w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" id="valor_venda" min="0" :value="`R$ `+formattedPrice" @input="handlePriceInput" placeholder="" type="text"/>
                                </div>
                                <!--
                                    <price-input v-model="valorVendaProduto"></price-input>
                                    -->

                            </input-container>

                            <input-container id="containerInputTipoDivisaoAtual" titulo="Tipo de Divisão Atual" id-help="inputTipoDivisaoAtualHelp" texto-ajuda="Tipo de Divisão Atual">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputTipoDivisaoAtual" aria-describedby="inputTipoDivisaoAtualHelp" :value="item.tipo_divisao" disabled>
                                
                            </input-container>

                            <input-container id="inputNovaDivisao" titulo="Nova Divisão" id-help="inputNovaDivisaoHelp">
                                <select-component id="tipo_divisao" route-name="opcoes/divisao" v-model="tipoDivisaoProduto"></select-component>
                            </input-container>

                            <div v-if="tipoDivisaoProduto == 'percentual'">
                                <input-container id="containerInputPorcentagemLojaNova" titulo="Nova Porcentagem da Loja: 10% - 50%" id-help="inputPorcentagemLojaNova"
                                    texto-ajuda="Porcentagem da Loja">
                                    <input type="range" class="" id="inputPorcentagemLojaNova" aria-describedby="inputPorcentagemLojaNovaHelp"
                                        min="10" max="50" step="5" @change="parteLoja = (valorVendaProduto * porcentagemLoja)/100" v-model="porcentagemLoja"
                                    >
                                    {{ porcentagemLoja + '%'}}
                                </input-container>

                                <input-container id="containerInputNovaParteLoja" titulo="Nova Parte da Loja" id-help="inputNovaParteLojaHelp"
                                    texto-ajuda="Nova Parte da Loja"
                                >
                                    <input type="text" class="input-patina" disabled id="inputNovaParteLoja" aria-describedby="inputParteLojaHelp" placeholder="R$ 0,00" :value="`R$ `+formattedStoreCut" @input="handleStoreCutInput">
                            
                                </input-container>
                            </div>

                            <div v-if="tipoDivisaoProduto == 'fixo'">
                                <input-container id="containerInputNovaParteLoja" titulo="Nova Parte da Loja" id-help="inputNovaParteLojaHelp"
                                >

                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-on-surface-variant ml-1" for="store_cut">Parte da Loja</label>
                                        <input class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium text-right" id="store_cut" min="0" :value="formattedStoreCut" @input="handleStoreCutInput" placeholder="" type="text"/>
                                    </div>
                                    <!--
                                        <price-input v-model="parteLoja"></price-input>
                                    -->
                                
                                </input-container>
                            </div>

                            <input-container id="containerInputParteLojaAtual" titulo="Parte da Loja Atual" id-help="inputParteLojaAtualHelp">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputParteLojaAtual" aria-describedby="inputParteLojaAtualHelp" :value="'R$ ' + formattedDisplayPrice(item.parte_loja)" disabled>
                                
                            </input-container>

                            <input-container id="containerInputStatusProdutoAtual" titulo="Status Atual do Produto" id-help="inputStatusProdutoAtualHelp">
                            
                                <input type="text" class="input-patina bg-yellow-200" id="inputStatusProdutoAtual" aria-describedby="inputStatusProdutoAtualHelp" :value="item.status" disabled>
                                
                            </input-container>

                            <input-container id="inputNovoStatusProduto" titulo="Novo Status do Produto" id-help="inputNovoStatusProdutoHelp">
                                <select-component id="status_produto" route-name="opcoes/status" v-model="statusProduto"></select-component>
                            </input-container>

                            <input-container id="inputEtiquetaProduto">
                                <label for="etiquetaProduto" class="block text-sm font-bold text-on-surface-variant ml-1">Etiqueta Atual</label>
                                <input id="etiquetaProduto" class="text-left w-full bg-yellow-200 border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" type="text" :value="item.etiqueta" placeholder="" disabled />
                            </input-container>

                            <input-container id="inputNovaEtiquetaProduto">
                                <label for="novaEtiquetaProduto" class="block text-sm font-bold text-on-surface-variant ml-1">Nova Etiqueta</label>
                                <input id="novaEtiquetaProduto" class="text-left w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" type="text" v-model="etiquetaProduto" placeholder="AAA-000" />
                            </input-container>
                                                    
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                        <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                    </template>
                </modal-component>
                <!--Fim Modal de Edição de produtos-->

                <!--Início do modal de Remover de Produto-->
                <modal-component id="modalProdutoRemover" titulo="Remover Produto">
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
                        <input-container class="flex justify-center">

                            <img
                                id="deleteImageField"
                                :src="srcUrlPath + $store.state.item.imagem"
                                alt="Imagem do Produto"
                                style="max-width: 200px; margin-top: 10px; border-radius: 6px;"
                                class="aspect-square rounded-lg bg-surface-variant flex flex-col items-center justify-center border-2 border-outline-variant/30 text-outline cursor-pointer hover:bg-surface-container-high transition-colors"
                            >
                            
                        </input-container>
                        <label for="deleteImageField" class="block font-headline font-bold text-on-surface text-center">Cód.: {{$store.state.item.etiqueta}}</label>
                        
                        <input-container titulo="Produto">
                            <input type="text" class="input-patina bg-red-300" :value="$store.state.item.nome" disabled>
                        </input-container>

                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="limparCampos()">Fechar</button>
                        <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    </template>
                </modal-component>
                <!--Fim do modal de Remover de marca-->


            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    computed:{
        item(){
            return this.$store.state.activeItem;
        },
        formattedPrice() {
            return (this.valorVendaProduto / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },

        formattedStoreCut() {
            return (this.parteLoja / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    },
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/produtos',
            urlPaginacao: '',
            urlFiltro: '',
            srcUrlPath: '/storage/',
            nomeProduto: '',
            tamanho: '',
            categoriaProduto: {},
            descricaoProduto: '',
            marcaProduto: '',
            valorVendaProduto: 0,
            tipoDivisaoProduto: '',
            porcentagemLoja: '',
            fornecedorProduto: '',
            statusProduto: '',
            parteLoja: '',
            imagemProduto: [],
            condicaoProduto: '',
            etiquetaProduto: '',
            produtoDestaque: '',
            produtos: [],
            //produtosDados é necessário devido à maneira que a paginação é feita
            produtosDados: [],
            busca:{
                etiqueta: '',
                nome:'',
            },
            transacaoStatus: '',
            transacaoDetalhes: {},
            previewUrl: null,
            opcoesDestaque: [
                { label: 'Sim', value: true },
                { label: 'Não', value: false }
            ],

        }
    },

    methods:{
        async editarVerProdutoCarregarInfo(){
            try {
                const response = await axios.get(this.urlBase + '/' + this.$store.state.item.id);

                const item = response.data;

                //console.log(item);

                this.$store.commit('setActiveItem', item)

                //preloading local edit fields
                this.nomeProduto = item.nome;
                this.categoriaProduto = item.categoria || {};
                this.descricaoProduto = item.descricao || '';
                this.marcaProduto = item.marca || {};
                this.condicaoProduto = item.condicao || '';
                this.valorVendaProduto = item.valor_venda;
                this.tipoDivisaoProduto = item.tipo_divisao || '';
                this.fornecedorProduto = item.fornecedor || {};
                this.statusProduto = item.status || '';
                this.parteLoja = item.parte_loja;
                this.tamanho = item.tamanho || '';
                this.imagemProduto = this.imagemProduto;
                this.etiquetaProduto = item.etiqueta;

                //console.log(item);

            } catch (errors) {
                console.log(errors)
            }
        },
        atualizar() {

            const formData = new FormData();
            formData.append('_method', 'patch');
        
            formData.append('nome', this.nomeProduto);
            formData.append('categoria_id', this.categoriaProduto?.id || null);
        
            if (this.categoriaProduto.id !== 2 &&
                this.categoriaProduto.id !== 3) {
                formData.append('tamanho', null);
            } else {
                formData.append('tamanho', this.tamanho);
            }

            formData.append('condicao', this.condicaoProduto);
        
            formData.append('descricao', this.descricaoProduto);
            formData.append('marca_id', this.marcaProduto?.id || null);
            formData.append('valor_venda', this.valorVendaProduto);
            formData.append('tipo_divisao', this.tipoDivisaoProduto);
            formData.append('fornecedor_id', this.fornecedorProduto?.id || null);
            formData.append('status', this.statusProduto);
            formData.append('parte_loja', this.parteLoja || null);
        
            if (this.imagemProduto instanceof File) {
                formData.append('imagem', this.imagemProduto);
            }
            formData.append('etiqueta', this.etiquetaProduto || null);

            //console.log(this.imagemProduto);

            //console.log([...formData.entries()]);
        
            axios.post(
                this.urlBase + '/' + this.$store.state.activeItem.id,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json'
                    }
                }
            )
            .then(() => {
                this.transacaoStatus = 'adicionado';
                this.transacaoDetalhes = 'Sucesso!'
                this.carregarLista();
            })
            .catch(errors => {
                console.log(errors);
                this.transacaoStatus = 'erro';
                this.transacaoDetalhes = {
                    dados: errors.response.data.errors
                };
            });
        },
        paginacao(l){
            if(l.url){
                this.urlPaginacao = l.url.split('?')[1] //ajusta a url base para a query
                this.carregarLista()
            }
            //console.log(this.produtos)
        },
        buscarProduto(){
            let filtro = '';
            //console.log(this.busca)

            for(let chave in this.busca){
                if(this.busca[chave]){
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

            this.carregarLista();
        },
        carregarLista(){
            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro;
            //console.log(this.url)

            axios.get(url)
                .then(response => {
                    this.produtos = response.data
                    this.produtosDados = this.produtos.data
                })
                .catch(errors => console.log(errors))
        },
        salvar(){
            let formData = new FormData();

            /*if(this.tipoDivisaoProduto == 'percentual'){
                this.parteLoja = parseFloat(this.valorVendaProduto * this.porcentagemLoja/100).toFixed(2);
            }*/

            formData.append('nome', this.nomeProduto);
            formData.append('categoria_id', this.categoriaProduto.id);
            formData.append('descricao', this.descricaoProduto);
            formData.append('marca_id', this.marcaProduto.id);
            formData.append('valor_venda', this.valorVendaProduto);
            formData.append('tipo_divisao', this.tipoDivisaoProduto);
            formData.append('fornecedor_id', this.fornecedorProduto.id);
            formData.append('status', this.statusProduto);
            formData.append('parte_loja', this.parteLoja);
            formData.append('imagem', this.imagemProduto);
            //formData.append('imagem', this.imagemProduto);
            formData.append('tamanho', this.tamanho);
            formData.append('condicao', this.condicaoProduto);
            formData.append('etiqueta', this.etiquetaProduto);
            //console.log([...formData.entries()]);

            let config = {
                headers:{
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            };

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do Registro: ' + response.data.id
                    };
                    this.carregarLista();
                })
                .catch(errors => {
                    console.log(errors);
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        //mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })

        },
        remover(){
            let confirmacao = confirm('Tem certeza que deseja remover este produto?')

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
            };

            //console.log(this.$store.state.item);

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso',
                    this.$store.state.transacao.mensagem = 'Produto removido com sucesso',
                    this.carregarLista()
                }).catch(
                    errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = 'Erro ao tentar remover o produto.'
                    }
                )
        },
        carregarImagem(e){
            const file = e.target.files[0];
            //this.imagemProduto = e.target.files[0];

            if(!file){
                this.imagemProduto = null;
                this.previewUrl = null;
                return;
            }

            //bind do arquivo para o formData
            this.imagemProduto = file;

            //URL de preview da imagem
            this.previewUrl = URL.createObjectURL(file)
        },
        limparStatus(){
            this.transacaoStatus = '';
                this.transacaoDetalhes = {
                    dados: ''
                };
        },
        limparCampos(){

            if (this.$refs.inputImagem) {
                this.$refs.inputImagem.value = null;
            }
        
            if (this.previewUrl) {
                URL.revokeObjectURL(this.previewUrl);
            }
            this.transacaoStatus = '';
            this.$store.state.transacao.dados = '';
            this.previewUrl = null;
            this.imagemProduto = null;
            this.nomeProduto = null;
            this.categoriaProduto.id = null;
            this.descricaoProduto = null;
            this.marcaProduto = null;
            this.valorVendaProduto = null;
            this.tipoDivisaoProduto = null;
            this.fornecedorProduto = null;
            this.statusProduto = null;
            this.parteLoja = null;
            this.tamanho = null;
            this.etiquetaProduto = null;
        },
        handlePriceInput(e) {
            const digits = e.target.value.replace(/\D/g, '');
            this.valorVendaProduto = Number(digits);
        },

        handleStoreCutInput(ev) {
            const storeCutValue = ev.target.value.replace(/\D/g, '');
            this.parteLoja = Number(storeCutValue);
        },
        formattedDisplayPrice(val){
            return (val / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },
        clearImgPreview(){
            return this.previewUrl = '';
        }
    },
    mounted(){
        this.carregarLista()
    },
    //função que remove a URL de prévia da imagem do produto
    beforeUnmount() {
        if (this.previewUrl) URL.revokeObjectURL(this.previewUrl);
    }

}
</script>

<style>

</style>
