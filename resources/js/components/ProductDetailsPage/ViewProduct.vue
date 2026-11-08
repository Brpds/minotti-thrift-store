<template>
    <div v-if="notFound == 404">
        <notfound-component></notfound-component>
    </div>
    <div class="container" v-if="!notFound">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <!-- Left: Asymmetrical Image Gallery -->
            <div class="lg:col-span-7 grid grid-cols-6 gap-4">
            <div class="col-span-6 overflow-hidden rounded-lg bg-surface-container shadow-sm">
            <img :alt="produto.descricao" class="w-full h-auto aspect-[4/5] object-cover hover:scale-105 transition-transform duration-700" :data-alt="produto.descricao"
                :src="produto.imagem"
            />
            </div>
            </div>
    
            <!-- Right: Product Details -->
            <div class="lg:col-span-5 flex flex-col gap-8 lg:sticky lg:top-32">
            <div class="space-y-2">
            
            <h1 class="font-headline text-4xl font-bold tracking-tight text-on-background leading-tight">{{ produto.nome }}</h1>
            <p class="text-3xl font-headline font-semibold text-twprimary">R$ {{ formatPrice(valorVenda) }}</p>
            <p class="text-[24px] text-on-surface-variant">Tamanho: {{produto.tamanho ? produto.tamanho :'Único'}}</p>
            </div>
            <div class="flex flex-col gap-6 p-8 bg-surface-container-low rounded-lg border border-outline-variant/10">
            <div class="flex justify-between items-center border-outline-variant/15">
            <span class="text-on-surface-variant font-label text-sm">Condição da Peça</span>
            <span class="font-semibold text-on-surface">{{ produto.condicao }}</span>
            </div>
            
            </div>
            
            <div class="flex flex-col gap-4">
                <a :href="whatsAppLink" target="_blank" class="btn">
                    <button class="w-full py-[1.25rem] rounded-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold text-lg hover:scale-[1.02] transition-transform duration-300 flex items-center justify-center shadow-lg shadow-primary/10 active:scale-95">
                        <span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
                        &nbsp;Eu Quero Este!
                    </button>
                </a>
            </div>
            <div class="mt-4 space-y-4">
            <h3 class="font-headline text-xl font-bold text-on-background">Detalhes da Peça</h3>
            <p class="text-on-surface-variant leading-relaxed font-body">
                {{ produto.descricao }}
            </p>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                produto: {},
                imagePath: '',
                valorVenda: '',
                notFound: null,
            }
        },
        mounted() {
          const id = window.location.pathname.split('/').pop();
          this.carregarProduto(id);
        },
        computed:{
            whatsAppLink(){
                const mensagem = `Olá, Minotti! Tenho interesse neste produto:
                Nome: ${this.produto.nome}
                Preço: ${this.produto.valor_venda}
                Link: ${this.urlProduto}`;

                return `https://wa.me/xxxxxxxx?text=${encodeURIComponent(mensagem)}`;
            },

            urlProduto(){
                return `${window.location.origin}/produtos/${this.produto.id}`
            }


        },
        methods: {
            async carregarProduto(id) {
              try{
                  const res = await axios.get(`/api/v1/vitrine/${id}`);
                  this.produto = res.data.data;
                  this.imagePath = this.produto.imagem;
                  this.valorVenda = this.produto.valor_venda.toString().replace('.', ',');
              }catch(errors){
                  this.notFound = errors.status;
                  //console.log(this.notFound);
              }
            },

            formatPrice(value) {
                return (value / 100).toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }
        }
    }
</script>