<template>
    <div>
        <form>
            <input-container id="inputNome" titulo="Nome" id-help="inputNomeHelp"
                        texto-ajuda="Nome do Produto"
                    >
            <input type="text" class="form-control" id="inputNome" aria-describedby="inputImagemHelp" placeholder="Nome do Produto">
            </input-container>
        
            <input-container id="inputImagem" titulo="Imagem" id-help="inputImagemHelp"
                        texto-ajuda="Insira uma Imagem PNG"
                    >
            <input type="file" class="form-control" id="inputImagem" aria-describedby="inputImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
            </input-container>
        
            <input-container id="inputCategoria" titulo="Categoria" id-help="inputCategoriaHelp"
                            texto-ajuda="Categoria"
                        >
                        <select-component id="categorias" route-name="categorias/list"></select-component>
            </input-container>
        
            <input-container id="inputFornecedor" titulo="Fornecedor" id-help="inputFornecedorHelp"
                            texto-ajuda="Fornecedor"
                        >
                        <select-component id="fornecedores" route-name="fornecedores/list"></select-component>
            </input-container>
        
            <input-container id="inputMarca" titulo="Marca" id-help="inputMarcaHelp"
                            texto-ajuda="Opcional"
                        >
                        <select-component id="marcas" route-name="marcas/list"></select-component>
            </input-container>
        
            <input-container id="inputDescricao" titulo="Descrição" id-help="inputDescricaoHelp"
                        texto-ajuda="Descrição"
                    >
            <textarea placeholder="Opcional"></textarea>
            </input-container>
        
            <input-container id="inputValorVenda" titulo="Valor de Venda" id-help="inputValorVendaHelp"
                            texto-ajuda="Valor de Venda"
                        >
                <input type="number" class="form-control" id="inputValorVenda" aria-describedby="inputValorVendaHelp" placeholder="Valor de Venda">
            </input-container>
        
            <input-container id="inputDivisao" titulo="Divisão" id-help="inputDivisaomHelp"
                            texto-ajuda="Tipo de Divisão"
                        >
                <select-component id="tipo_divisao" route-name="opcoes/divisao"></select-component>
            </input-container>
        
            <input-container id="inputStatusProduto" titulo="Status Produto" id-help="inputStatusProdutoHelp"
                            texto-ajuda="Status do Produto"
                        >
                <select-component id="status_produto" route-name="opcoes/status"></select-component>
            </input-container>
        
            <input-container id="inputParteLoja" titulo="Parte da Loja" id-help="inputParteLojaHelp"
                            texto-ajuda="Parte da Loja"
                        >
                <input type="number" class="form-control" id="inputParteLoja" aria-describedby="inputParteLojaHelp" placeholder="Parte da Loja">
            </input-container>
        </form>
        <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>