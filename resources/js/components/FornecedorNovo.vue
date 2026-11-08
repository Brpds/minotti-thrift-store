<template>
    <div>
        <form>
            <input-container id="inputNome" titulo="Nome" id-help="inputNomeHelp"
                        texto-ajuda="Nome do Fornecedor"
                    >
            <input type="text" class="form-control" id="inputNome" aria-describedby="inputImagemHelp" placeholder="Nome do Fornecedor">
            </input-container>
        
            <!--<input-container id="inputImagem" titulo="Imagem" id-help="inputImagemHelp"
                        texto-ajuda="Insira uma Imagem PNG"
                    >
            <input type="file" class="form-control" id="inputImagem" aria-describedby="inputImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
            </input-container>
            -->

            <input-container id="inputCPF" titulo="CPF" id-help="inputCPF"
                        texto-ajuda="CPF"
                    >
            <input type="text" class="form-control" id="inputCPF" aria-describedby="inputCPFHelp" placeholder="CPF do Fornecedor">
            </input-container>

            <input-container id="inputEndereco" titulo="Endereço" id-help="inputEnderecoHelp"
                        texto-ajuda="Endereço do Fornecedor"
                    >
            <input type="text-area" class="form-control" id="inputEndereco" aria-describedby="inputEnderecoHelp" placeholder="Endereço do Fornecedor">
            </input-container>

            <input-container id="inputTelefone" titulo="Telefone" id-help="inputTelefoneHelp"
                        texto-ajuda="Telefone do Fornecedor"
                    >
            <input type="tel" class="form-control" id="inputTelefone" aria-describedby="inputTelefoneHelp" placeholder="(00) 00000 - 0000">
            </input-container>

            <input-container id="inputChavePix" titulo="Chave Pix" id-help="inputChavePixHelp"
                        texto-ajuda="Chave Pix do Fornecedor"
                    >
            <input type="text" class="form-control" id="inputChavePix" aria-describedby="inputChavePixHelp" placeholder="Chave Pix do Fornecedor">
            </input-container>

        </form>

        <!--Início do Alert inserção-->
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
        <!--fim do Alert inserção-->
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>