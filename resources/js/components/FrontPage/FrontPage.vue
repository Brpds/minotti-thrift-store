<script setup>
import axios from 'axios';
import { ref } from 'vue'

// Newsletter state (only real logic for now)
const email = ref('')

const subscribe = async () => {
  if(!email.value) return
  try {
    await axios.post('api/subscribers', {email: email.value});
    console.log('Subscribed:', email.value);
    email.value = '';
  } catch (error) {
    console.log(error.response.data);
  }

}
</script>

<template>
  <div class="bg-pink-100 text-on-surface font-body">

    <main class="">
      <!-- Hero -->
      <section class="relative px-6 py-12 md:py-24 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">

          <div class="md:col-span-5">
            <span class="text-xs uppercase tracking-[0.2em] text-secondary font-bold mb-4 block">
              Infância Sustentável
            </span>

            <h1 class="text-5xl font-['Plus_Jakarta_Sans'] md:text-7xl font-extrabold mb-8">
              Peças cobertas de carinho para seu pequeno.
            </h1>

            <a class="text-decoration-none" href="/vitrine">
              <button class="inline-flex hover:scale-105 duration-200 transition-transform items-center px-10 bg-gradient-to-r from-primary-container to-primary tracking-tight hover:opacity-90 shadow-lg shadow-primary/20 active:scale-95 duration-200px-10 py-4 bg-[#d087cb] text-white rounded-xl font-bold">
                Ver Tudo
                <span class="material-symbols-outlined ml-2 text-sm">arrow_forward</span>
              </button>
            </a>
          </div>

          <div class="md:col-span-7">
            <div class="md:aspect-[16/10] rounded-[2.5rem] overflow-hidden bg-[#fbe8d1]">
              <!--
                <img
                class="md:h-full object-cover mx-auto"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC5IJqWBq8Jddp1lmUCJDLRViuU1-iJ7fYsygna-G3G85uNHdjuBZ29sWSWHOlDQaSavkEGrh07zu-mjuqX4PO0WDqRV_Iyyn4W_-1CIheCqWh04vhlz2Uf-1BzkGBGgROoCgeufWXDKChIsTyTACiq6DxBR5ykLKZWww1VqaqZ8FVMG0eIyWPN5uwE4_gg_q2KLmSAVPkZ8rSw4T737t_WybIgJVbQUtHE2uvEMypWi2PfaRN60ucbB_6SuGajpagIDUCU8u3XM48g"
                />
              -->
              <img
                class="md:h-full object-cover mx-auto"
                :src="`storage/imagens/frontpage/frontpagemodel.png`"
              />
            </div>
          </div>

        </div>
      </section>

      <!-- Categories -->
      <section class="py-20 px-6 max-w-7xl mx-auto">
        <h2 class="font-['Plus_Jakarta_Sans'] text-3xl font-bold mb-8">Explore por Etapas</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div v-for="cat in categories" :key="cat.id" class="group cursor-pointer">
            <a class="text-decoration-none" href="/vitrine">
              <div class="overflow-hidden transition-transform duration-500 group-hover:scale-[1.02] aspect-square bg-surface-container rounded-xl mb-4">
                  <img class="rounded-xl w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all" :src="`storage/imagens/frontpage/frontpage-category-${cat.id}.png`">
              </div>
                <p class="font-semibold text-[#251A05] font-['Plus_Jakarta_Sans']">{{ cat.nome }}</p>
			          <span class="text-xs text-on-surface-variant opacity-70">{{ cat.subtitle }}</span>
            </a>
          </div>
        </div>
      </section>

      <!-- Featured -->
      <section class="bg-surface-container-low py-24 rounded-[3rem] mx-4">
        <div class="max-w-7xl mx-auto px-6">
          
          <div class="flex justify-between mb-12">
            <h2 class="font-headline text-4xl font-bold">Produtos em Destaque</h2>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
              <frontpagefeaturedproducts-component>
              </frontpagefeaturedproducts-component>
          </div>
          
        </div>
        <a class="flex text-decoration-none link-hover text-surface-tint font-bold text-sm border-primary/20 hover:border-primary transition-all pb-1 mx-auto justify-center" href="/vitrine">
          Ver todos os itens
          <span class="material-symbols-outlined ml-2 text-sm">arrow_forward</span>
        </a>
      </section>

      <!-- Brand Values -->
      <section class="py-24 px-6 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-3 gap-16 text-center md:text-left">

          <div>
            <div class="w-14 h-14 bg-[#d087cb] rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
            <span class="material-symbols-outlined text-white text-3xl" style="font-variation-settings: 'FILL' 1;">verified</span>
            </div>
            <h4 class="font-headline font-bold mb-2">Curadoria de Qualidade</h4>
            <p>Peças selecionadas minuciosamente.</p>
          </div>

          <div>
            <div class="w-14 h-14 bg-[#d087cb] rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
            <span class="material-symbols-outlined text-white text-3xl" style="font-variation-settings: 'FILL' 1;">eco</span>
            </div>
            <h4 class="font-bold mb-2 font-headline">Sustentabilidade</h4>
            <p>Protegendo o planeta.</p>
          </div>

          <div>
            <div class="w-14 h-14 bg-[#d087cb] rounded-2xl flex items-center justify-center mb-6 mx-auto md:mx-0">
            <span class="material-symbols-outlined text-white text-3xl" style="font-variation-settings: 'FILL' 1;">favorite</span>
            </div>
            <h4 class="font-bold mb-2 font-headline">Gentilmente Amadas</h4>
            <p>Estórias passadas adiante.</p>
          </div>

        </div>
      </section>

      <!-- Newsletter -->
      <section class="mb-20 px-6 max-w-5xl mx-auto">
        <div class="bg-primary-fixed rounded-[2.5rem] p-12 text-center md:p-20 relative overflow-hidden">

          <h2 class="text-4xl font-bold mb-4 font-headline">
            Entre na nossa comunidade
          </h2>
          <p class="text-on-primary-fixed-variant max-w-md mx-auto mb-10">Fique sempre por dentro das novidades. Nós te contaremos tudo sempre que novas peças chegarem!</p>

          <form @submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
            <input
              v-model="email"
              type="email"
              placeholder="Seu Email"
              maxlength="255"
              class="flex-grow rounded-xl px-6 py-4"
            />
            <button class="inline-flex justify-center overflow-hidden items-center hover:scale-105 px-10 bg-gradient-to-r from-primary-container to-primary tracking-tight hover:opacity-90 transition-all shadow-lg shadow-primary/20 active:scale-95 duration-200px-10 py-4 bg-[#d087cb] text-white rounded-xl font-bold font-headline">
              Receber Novidades
            </button>
          </form>

        </div>
      </section>

    </main>
  </div>
</template>

<script>
	export default{
		data(){
			return{
				categories: [
					{id: '1', nome: 'Recém-Nascidos', subtitle: 'RN - 24 meses'},
					{id: '2', nome: 'Pequeninos', subtitle: '2 - 5 anos'},
					{id: '3', nome: 'Crianças', subtitle: '5 - 12 anos'},
					{id: '4', nome: 'Brinquedos e Acessórios', subtitle: ''},
				],
			}
		}
	}
</script>