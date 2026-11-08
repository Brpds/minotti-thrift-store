<template>
    <div class="form-group">
        <input-container id="novoMarca" titulo="Nome da Marca" id-help="novoMarcaHelp"
                        texto-ajuda="Informe o nome da Marca"
                    >
            <input type="text" class="form-control" id="novoMarca" aria-describedby="novoMarcaHelp" placeholder="Nome da Marca" v-model="nomeMarca">
        </input-container>
    </div>
    <div class="form-group">
        <input-container id="inputImagem" titulo="Imagem" id-help="inputImagemHelp"
                        texto-ajuda="Insira uma Imagem PNG"
                    >
            <input type="file" class="form-control" id="inputImagem" aria-describedby="inputImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
        </input-container>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>