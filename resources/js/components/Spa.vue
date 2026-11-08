<template>
	<div>
    	<ul class="nav nav-tabs">
    	  <li class="nav-item">
    	    <a class="nav-link"
    	      :class="{active: guiaAtual === 'produto'}"
    	      aria-current="page" href="#"
    	      @click.prevent="guiaAtual = 'produto'"
    	      >Produto</a>
    	  </li>
    	  <li class="nav-item">
    	    <a class="nav-link"
    	      :class="{active: guiaAtual === 'fornecedor'}"
    	      aria-current="page" href="#"
    	      @click.prevent="guiaAtual = 'fornecedor'"
    	    >Fornecedor</a>
    	  </li>
    	  <li class="nav-item">
    	    <a class="nav-link"
    	      :class="{active: guiaAtual === 'marca'}"
    	      aria-current="page" href="#"
    	      @click.prevent="guiaAtual = 'marca'"
    	    >Marca</a>
    	  </li>
    	</ul>

		<div class="mt-3">
			<newProduct-component v-if="guiaAtual === 'produto'"></newProduct-component>
			<newFornecedor-component v-if="guiaAtual === 'fornecedor'"></newFornecedor-component>
			<newMarca-component v-if="guiaAtual === 'marca'"></newMarca-component>
		</div>
	</div>
</template>

<script>
export default {
	data(){
		return {
			guiaAtual: 'produto'
		}
	}
}
</script>

<style>

</style>