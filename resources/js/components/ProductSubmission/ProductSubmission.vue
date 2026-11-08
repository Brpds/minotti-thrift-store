<template>
    <main class="pt-14 pb-20 px-6 max-w-5xl mx-auto">
        <h1 class="text-5xl md:text-6xl font-headline font-extrabold text-on-surface tracking-tighter mb-6 leading-tight">
            Incluir <span class="text-twprimary">Peça</span>
        </h1>

        <div class="lg:col-span-8">
            <div class="bg-surface-container-lowest p-8 md:p-12 rounded-lg shadow-[0px_10px_30px_rgba(135,70,133,0.05)]">
                <form action="#" class="space-y-10">
                    <!-- Image Upload Area -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                            
                            <div @click="$refs.fileInput.click()" class="col-span-full md:col-span-2 md:col-start-2 aspect-square rounded-lg bg-surface-variant flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/30 text-outline cursor-pointer hover:bg-surface-container-high transition-colors">
                                <img 
                                    v-if="previewUrl" 
                                    :src="previewUrl" 
                                    class="w-full h-full object-cover rounded-lg"
                                />
                                
                                <div v-else class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-4xl mb-2">
                                        add_a_photo
                                    </span>
                                    <span class="text-xs font-bold uppercase tracking-widest">
                                        Main View
                                    </span>
                                </div>
                                <!--
                                    <span class="material-symbols-outlined text-4xl mb-2" data-icon="add_a_photo">add_a_photo</span>
                                    <span class="text-xs font-bold uppercase tracking-widest">Main View</span>
                                    -->
                            </div>

                            <!-- Hidden input -->
                            <input 
                                type="file" 
                                id="imageField"
                                ref="fileInput" 
                                class="hidden" 
                                accept="image/*"
                                @change="handleFileUpload"
                            />
                        </div>
                        <span v-if="this.previewUrl" @click="clearImgPreview()" class="material-symbols-outlined block text-center cursor-pointer">
                            delete
                        </span>
                        <label for="imageField" class="block font-headline font-bold text-on-surface text-center">Imagem</label>
                    </div>
                    <!-- Basic Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="nomeInput" class="block text-sm font-bold text-on-surface-variant ml-1">Nome</label>
                            <input id="nomeInput" class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" placeholder="ex.: Romper, Body &amp; Vestido" type="text"/>
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="description">Descrição da Peça</label>
                            <textarea class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium resize-none" id="description" placeholder="Escreva os detalhes da peça..." rows="4"></textarea>
                        </div>

                        <!--categoria-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="categoriPproduto">Categoria</label>
                            <select-component id="categoriaProduto" route-name="categorias/list" v-model="cateogria"></select-component>
                        </div>

                        <!--tamanho roupa-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="tamanho_roupa">Tamanho da Roupa</label>
                            <select-component id="tamanho_roupa" route-name="tamanhoroupa" v-model="tamanhoRoupa"></select-component>
                        </div>

                        <!--tamanho calçado-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="tamanho_calcado">Tamanho do Calçado</label>
                            <select-component id="tamanho_calcado" route-name="tamanhocalcado" v-model="tamanhoCalcado"></select-component>
                        </div>

                        <!--condição-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="condicao">Condição da Peça</label>
                            <select-component id="condicao" route-name="opcoes/condicao" v-model="condicao"></select-component>
                        </div>

                        <!--marca-->
                        <div class="space-y-2">
                            <label for="marca" class="block text-sm font-bold text-on-surface-variant ml-1">Marca</label>
                            <select-component id="marca" route-name="marcas/list" v-model="marca"></select-component>
                        </div>

                        <!--valor de venda-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="valor_venda">Valor de Venda</label>
                            <input class="text-right w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" id="valor_venda" min="0" :value="formattedPrice" @input="handlePriceInput" placeholder="" type="text"/>
                        </div>

                        <!--tipo de divisão-->
                        <div class="space-y-2">
                            <label for="divisao" class="block text-sm font-bold text-on-surface-variant ml-1">Tipo de Divisão</label>
                            <select-component id="divisao" route-name="opcoes/divisao" v-model="divisao"></select-component>
                        </div>

                        <!--parte da loja-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="store_cut">Parte da Loja</label>
                            <input class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium text-right" id="store_cut" min="0" :value="formattedStoreCut" @input="handleStoreCutInput" placeholder="" type="text"/>
                        </div>

                        <!--etiqueta-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="storetag">Etiqueta</label>
                            <input class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" id="storetag" placeholder="AAA-000" type="text"/>
                        </div>

                        <!--status-->                        
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="status_produto">Status</label>
                            <select-component id="status_produto" route-name="opcoes/status" v-model="statusProduto"></select-component>
                        </div>

                        <!--fornecedor-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="fornecedor">Fornecedor</label>
                            <input class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary/20 font-medium" id="fornecedor" placeholder="AAA-000" type="text"/>
                        </div>

                        <!--destaque-->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-on-surface-variant ml-1" for="destaque">Destaque  - Aparecerá na Página Principal</label>
                            <select class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary/20 appearance-none font-medium" id="destaque">
                                <option value="">Destaque</option>
                                <option v-for="opt, key in opcoesDestaque" :key="key" :value="opt.value">{{ opt.label }}</option>
                                
                            </select>
                        </div>

                    </div>
                    
                    <!-- Submit Section -->
                    <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-6">
                        <button class="w-full md:w-auto bg-gradient-to-r from-primary to-primary-container text-on-primary px-[2.5rem] py-[1.25rem] rounded-full font-headline font-bold text-lg transition-transform hover:scale-[1.02] active:scale-95 shadow-[0px_10px_30px_rgba(135,70,133,0.15)]" type="submit">
                            Adicionar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    data(){
        return {
            previewUrl: '',
            imagemProduto: '',
            nomeProduto: '',
            descricaoProduto:'',
            categoriaProduto: '',
            tamanho: '',
            condicaoProduto:'',
            marcaProduto: '',
            valorVenda: 0,
            tipoDivisaoProduto: '',
            parteLoja: 0,
            etiqueta: '',
            statusProduto: '',
            fornecedorProduto: '',
            destaque: false,
            categoria: {},
            marca: {},
            fornecedor: {},
            tamanhoCalcado: {},
            tamanhoRoupa: {},
            status: {},
            opcoesDestaque: [
                { label: 'Sim', value: true },
                { label: 'Não', value: false}
            ],
            divisao: {},

        }
    },
    methods: {
        salvar(){
            let formData = new FormData();

            if(this.tipoDivisaoProduto == 'percentual'){
                this.parteLoja = parseFloat(this.valorVendaProduto * this.porcentagemLoja/100).toFixed(2);
            }

            formData.append('nome', this.nomeProduto);
            formData.append('categoria_id', this.categoriaProduto.id);
            formData.append('descricao', this.descricaoProduto);
            formData.append('marca_id', this.marcaProduto.id);
            formData.append('valor_venda', this.valorVenda);
            formData.append('tipo_divisao', this.tipoDivisaoProduto);
            formData.append('fornecedor_id', this.fornecedorProduto.id);
            formData.append('status', this.statusProduto);
            formData.append('parte_loja', this.parteLoja);
            formData.append('imagem', this.imagemProduto);
            formData.append('tamanho', this.tamanho);
            formData.append('condicao', this.condicaoProduto);
            formData.append('desatque', this.destaque);
            formData.append('etiqueta', this.etiqueta);



            console.log([...formData.entries()]);

            let config = {
                headers:{
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json'
                }
            };

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do Registro: ' + response.data.id
                    };
                    this.carregarLista();
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        //mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })

        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            console.log(file);

            this.previewUrl = URL.createObjectURL(file);
        },
        clearImgPreview(){
            this.previewUrl = '';
        },
        //método que trata o número inserido nos campos valor_venda e parte_loja
        handlePriceInput(e) {
            const digits = e.target.value.replace(/\D/g, '');
            this.valorVenda = Number(digits);
        },

        handleStoreCutInput(ev) {
            const storeCutValue = ev.target.value.replace(/\D/g, '');
            this.parteLoja = Number(storeCutValue);
        }
    },
    computed: {
        formattedPrice() {
            return (this.valorVenda / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },

        formattedStoreCut() {
            return (this.parteLoja / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    },
}
</script>

<style>

</style>