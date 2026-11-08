<template>
    <article class="group cursor-pointer">
        <div class="relative aspect-[3/4] overflow-hidden rounded-2xl bg-surface-container-low shadow-sm">
            <img class="w-full h-full object-cover" :data-alt="produto.descricao" :src="produto.imagem"/>
        </div>
        <div class="mt-3 space-y-1">
            <div class="flex flex-col">
                <h3 class="text-sm font-bold text-on-surface line-clamp-1">{{ produto.nome }}</h3>
                <span class="text-sm text-right font-headline font-bold text-twprimary">{{ formatPrice(produto.valor_venda.toString().replace('.', ',')) }}</span>
            </div>
            <p class="text-[10px] text-on-surface-variant">{{produto.tamanho ? produto.tamanho : 'Tam. Único'}}</p>
        </div>
    </article>
</template>

<script>
export default {
    props: ['produto'],
    methods: {
        formatPrice(value) {
            return (value / 100).toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        }
    },
}
</script>

<style>

</style>