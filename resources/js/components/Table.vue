<template>
    <div class="overflow-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-twprimary text-on-tertiary-container">
                    <th scope="col" v-for="t, key in titulos" :key="key" class="px-8 py-6 font-headline font-bold uppercase tracking-wider text-xs" >{{ t.titulo }}</th>
                    <th v-if="ver.visivel || editar.visivel || excluir.visivel"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container">
                <!--
                <tr v-for="obj in dados" :key="obj.id">
                    <td v-for="(valor, chave) in includesTitulos(obj)" :key="chave">
                        <span v-if="chave == 'imagem'">
                            <img :src="'/storage/'+valor" width="36" height="36">
                        </span>
                        <span v-else>
                            {{ valor }}
                        </span>
                    </td>
                </tr>
                -->
                <tr v-for="obj, chave in dadosFiltrados" :key="chave" class="hover:bg-twprimary/30 transition-colors group">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor" class="px-8 py-6 text-sm font-medium text-on-surface-variant">
                        <span v-if="titulos[chaveValor].tipo == 'number'">R$ {{ formatarMoeda(valor) }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'text'">{{ valor }}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-surface-container shadow-sm border border-outline-variant/10">
                                <img :src="srcUrlPath + valor" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            </div>
                        </span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor }}</span>
                    </td>
                    <td v-if="ver.visivel || editar.visivel || excluir.visivel" class="px-8 py-6">
                        <div class="flex justify-end gap-3">

                            <button v-if="ver.visivel" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-container-high text-secondary transition-colors"
                            :data-bs-toggle="ver.dataToggle" :data-bs-target="ver.dataTarget"
                            @click="setStore(obj); ver?.onVer && ver.onVer()"
                            ><span class="material-symbols-outlined">visibility</span></button>
                            <button v-if="editar.visivel" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-container-high text-twprimary transition-colors"
                            :data-bs-toggle="editar.dataToggle" :data-bs-target="editar.dataTarget"
                            @click="setStore(obj); editar?.onEditar && editar?.onEditar()"
                            ><span class="material-symbols-outlined">edit</span></button>
                            <button v-if="excluir.visivel" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-error-container/20 text-error transition-colors"
                            :data-bs-toggle="excluir.dataToggle" :data-bs-target="excluir.dataTarget"
                            @click="setStore(obj)"
                            ><span class="material-symbols-outlined">delete</span></button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['dados', 'titulos','srcUrlPath', 'ver', 'editar', 'excluir', 'onEditar', 'onVer', 'onRemover'],
    methods:{
        //adiciona no VueX os itens escolhidos a partir dos títulos
        setStore(obj){
            this.$store.state.transacao.status = ''
            this.$store.state.transacao.mensagem = ''
            this.$store.state.item = obj
        },
        formatarMoeda(val) {
          // Transforma 1500 em 15.00
          const decimal = val / 100; 

          return new Intl.NumberFormat('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          }).format(decimal);
        }
    },
    computed:{
        dadosFiltrados(){
            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []
            
            this.dados.map((item, chave) => {
                
                let itemFiltrado = {}

                campos.forEach(campo => {
                    itemFiltrado[campo] = item[campo]
                    
                })
                dadosFiltrados.push(itemFiltrado)
            })
            return dadosFiltrados
        },

    }
}
</script>

<style>

</style>