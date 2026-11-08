<template>
    <div v-for="produto in produtosDestaque" :key="produto.id" class="flex flex-col">
        <a class="text-decoration-none mb-3" :href="`/vitrine/${produto.id}`">
            <div class="aspect-[3/4] bg-gray-200 rounded-2xl overflow-hidden relative group mb-4">
                <img :alt="produto.descricao" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Brown organic cotton overalls on a hanger" :src="produto.imagem"/>
            </div>
            <h3 class="font-label text-xl font-bold text-twprimary">{{ produto.nome }}</h3>
            <p class="text-on-surface text-right font-bold text-xl">{{ formatPrice(produto.valor_venda.toString().replace('.', ',')) }}</p>
        </a>
    </div>
</template>

<script>
export default {
    data(){
        return {
            produtosDestaque: [],
            valorVenda: '',
        }
    },
    methods:{
        async loadDestaques(){
            const res = await axios.get('/api/v1/destaque');
            this.produtosDestaque.push(...res.data.data);
        },
        formatPrice(value) {
            return (value / 100).toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        }
    },
    mounted(){
        this.loadDestaques();
    }
}
</script>