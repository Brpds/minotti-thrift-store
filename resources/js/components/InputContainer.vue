<template>
    <div class="form-group mb-6">
        <label :for="id" class="label-patina">{{ titulo }}</label>
        <slot></slot>
        <div :id="idHelp" class="form-text">{{ textoAjuda }}</div>
    </div>
</template>

<script>
export default {
    props:['id', 'titulo', 'idHelp', 'textoAjuda']
}
</script>

<style>

</style>