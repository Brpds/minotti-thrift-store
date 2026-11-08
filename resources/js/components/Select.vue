<script setup>
defineProps({
  modelValue: [String], // or whatever you expect
  id: String,
  routeName: String,
  titulo: String
});

defineEmits(['update:modelValue']);
</script>

<template>
    <label :for="id+'-select'" block text-sm font-bold text-on-surface-variant ml-1>{{ titulo }}</label>

    <select class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary/20 appearance-none font-medium" :name="titulo" :id="id+'-select'" v-model="selected" @change="$emit('update:modelValue', $event.target.value)">
      <option value="">--Selecione--</option>
      <option v-for="opt, key in opcoes" 
            :key="key" class="text-capitalize"
            :value="opt.nome"
        >{{ opt.nome }}</option>
    </select>
</template>

<script>
export default {
    props: ['titulo', 'id', 'routeName'],
    emits: ["update:modelValue"],
    data(){
        return {
            urlSelectOpcoes: 'http://127.0.0.1:8000/api/v1/' + this.routeName,
            opcoes:[],
            selected: '',
        }
    },
    watch: {
        selected(newVal) {
          this.$emit("update:modelValue", newVal);
        }
    },
    methods:{
        carregarOpcoes(){
            axios.get(this.urlSelectOpcoes)
                .then(response => {
                    this.opcoes = response.data
                    //console.log(this.opcoes)
                })
                .catch( errors => console.log(errors))
        }
    },
    mounted(){
        this.carregarOpcoes()
    }
}
</script>

<style>

</style>