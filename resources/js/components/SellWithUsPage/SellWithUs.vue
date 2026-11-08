<template>
    <main class="">
        <!-- Hero Section: Editorial & Asymmetric -->
        <section class="relative px-6 md:px-12 py-4 md:py-16 max-w-7xl mx-auto overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
            <div class="md:col-span-7 z-10">
                <h1 class="font-headline text-5xl md:text-7xl font-extrabold tracking-tighter text-on-surface leading-tight mb-6">
                    Passe o <span class="text-twprimary italic">Amor</span> adiante.
                </h1>
                <p class="font-body text-lg md:text-xl text-on-surface-variant max-w-lg mb-10 leading-relaxed">
                    Dê uma segunda vida às peças que seus pequenos adoram, mas agora eles estão grandes demais pra elas. Nossa plataforma se encarrega de escolher o novo par perfeito para novas estórias.
                </p>
                <a class="text-decoration-none" href="#queroVender">
                    <button class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-10 py-[1.25rem] rounded-full font-headline font-bold text-lg shadow-xl shadow-primary/10 transition-transform duration-200 hover:scale-105 active:scale-95">
                        Quero vender! <!--<span class="material-symbols-outlined text-sm">arrow_outward</span>-->
                    </button>
                </a>
            </div>
            <!--imagens-->
            <div class="md:col-span-5 relative">
                <div class="rounded-lg overflow-hidden aspect-[4/5] bg-surface-container shadow-2xl rotate-2 transition-transform hover:rotate-0 duration-500">
                    <img class="w-full h-full object-cover" data-alt="Beautifully curated vintage children clothes hanging on a wooden rack" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPDCqiz55P14YD0U-lqtsEITq589O8LhcdNY3f4xzP02-dGe-e-PJa4c8cPul6S15se45v-CybIJmJYcPUKgKVAu5-WcOg7nvbgwf9R2ww5AvPgzHQZ6fL7aI3ggO_cBEV1XumdcYYkhVW7opQw0H9-KJ2Yy-smMZ7W9I9DUYEldoP7iVKMSqj48lhmTTZWuBSZeqRD12Yh4RZItFk5EsZaDUIxPMtuHSEh45gPNWT1Z5n1rUBWxBudBRQ_a9CzvbLx6q9JegQbHei"/>
                </div>
                <div class="absolute -bottom-6 -left-6 w-32 h-32 md:w-48 md:h-48 rounded-lg overflow-hidden border-8 border-white shadow-xl -rotate-6 hidden md:block">
                    <img class="w-full h-full object-cover" data-alt="Close up of high quality fabric texture of a baby sweater" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCe0HUKgd-Tw3S7IMmlrIioHCViJgUWXAjQ7nUNpIIXl8jHIqiXu28DBFisRPttR5jtn9wHM4sRtsbNXy3xl6sk1ArDwkufdHkW5uVza7BM4rvgDln3jqw8nHcgNzHmD74QykLGITq3WUgLvpPn--rr6WSDw2f7SK3zSzvVebUKHLqUr9gd3k7NdxB5246_Xs-sb9GBjGBpP352fuBeTKhTWIWVtNZCr-YcVjHWwFrLfwcKhMe3yTfVeWMcCg9IiHmSQu87iRXFdhwp"/>
                </div>
            </div>
        </div>
        </section>
        <!-- Process Section: Bento Grid Layout -->
        <section id="queroVender" class="bg-surface-container py-24 px-6 md:px-12">
            <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                        <div class="max-w-2xl">
                            <h2 class="font-headline text-4xl font-bold tracking-tight text-on-surface mb-4">Como funciona?</h2>
                            <p class="font-body text-on-surface-variant text-lg italic">A Jornada até novas brincadeiras.</p>
                        </div>
                    </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-surface-container-lowest p-10 rounded-lg flex flex-col h-full transition-transform duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-twprimary mb-8">
                            <span class="material-symbols-outlined text-3xl" data-icon="temp_preferences_custom">temp_preferences_custom</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold text-on-surface mb-4">1. Limpe e Selecione</h3>
                        <p class="font-body text-on-surface-variant leading-relaxed">
                            Escolha as peças e <strong>higienize-as</strong>. Dê preferência àquelas com poucas marcas, em boas condições de uso Priorizamos qualidade em vez de quantidade.
                        </p>
                        <div class="mt-auto pt-8">
                            <span class="text-xs font-headline font-bold uppercase tracking-widest text-twprimary/60">Primeiro Passo</span>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="bg-surface-container-lowest p-10 rounded-lg flex flex-col h-full transition-transform duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 rounded-full bg-secondary-container/30 flex items-center justify-center text-secondary mb-8">
                            <span class="material-symbols-outlined text-3xl" data-icon="package">package_2</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold text-on-surface mb-4">2. Prepare o Lote</h3>
                        <p class="font-body text-on-surface-variant leading-relaxed">
                            Com as peças já selecionadas, contate-nos para marcar um horário de avaliação dos itens. Atente ao mínimo de 10 peças.
                        </p>
                        <div class="mt-auto pt-8">
                            <span class="text-xs font-headline font-bold uppercase tracking-widest text-twprimary/60">Segundo Passo</span>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="bg-surface-container-lowest p-10 rounded-lg flex flex-col h-full transition-transform duration-300 hover:-translate-y-2">
                        <div class="w-14 h-14 rounded-full bg-tertiary-container/20 flex items-center justify-center text-[#85BB65] mb-8">
                            <span class="material-symbols-outlined text-3xl" data-icon="payments">payments</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold text-on-surface mb-4">3. Consignação</h3>
                        <p class="font-body text-on-surface-variant leading-relaxed">
                            Após a aprovação das peças e negociação de preços com você, as peças ficam à disposição na loja. O pagamento se dará em dinheiro ou crédito na loja após a venda.
                        </p>
                        <div class="mt-auto pt-8">
                            <span class="text-xs font-headline font-bold uppercase tracking-widest text-twprimary/60">Terceiro Passo</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Quality Standards Section: Tonal Color Blocking -->
        <section class="py-24 px-6 md:px-12 bg-surface">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="order-2 md:order-1">
                    <div class="relative">
                        <div class="rounded-lg overflow-hidden aspect-square shadow-xl">
                            <img class="w-full h-full object-cover" data-alt="A toddler wearing a minimalist designer linen romper playing in a field" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC6W1rXqw1M5coIbno9LWAfNguhSGO3WgHvmdP36hB739HmfNXUuJAh7fjMQk-7GNm284DVPkGz_SDf1y5WESafeSvDdoIIyn0C50u2_72lUl8TOQZVAOsmXsdo6StASHOGQfCvCWG58NwpOdfg4L4ycLLWf_mKDI4Hyhx2X79PcKk8XwVbTtbXiPXQqi3veFYEIW9HWI9rncI04960mdlH3g9foV_55u2NVb94SPQxtL6ck_kInyb3blUtuPfhhf9f6RXSJjcol51j"/>
                        </div>
                        <div class="absolute -top-10 -right-10 bg-tertiary-container text-on-tertiary-container p-8 rounded-lg shadow-2xl max-w-[240px] hidden lg:block">
                            <p class="font-headline font-bold text-xl italic mb-2">"Amor e Cuidado transmitidos em forma de roupinhas."</p>
                        </div>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <span class="text-twprimary font-headline font-bold tracking-widest uppercase text-sm mb-4 block">Nossos Padrões</span>
                    <h2 class="font-headline text-4xl md:text-5xl font-bold text-on-surface mb-8 leading-tight">O que aprovamos?</h2>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-twprimary" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <div>
                                <span class="font-headline font-bold text-lg text-on-surface block">Usadas, Perdidas ou Esquecidas</span>
                                <p class="font-body text-on-surface-variant">Usou poucas vezes, cresceu antes ou esquecidas no guarda-roupa.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-twprimary" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <div>
                                <span class="font-headline font-bold text-lg text-on-surface block">Qualidade Importa</span>
                                <p class="font-body text-on-surface-variant">A qualidade do que vendemos diz tudo sobre nossa loja. Vem conferir!</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-twprimary" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <div>
                                <span class="font-headline font-bold text-lg text-on-surface block">Condição Excelente</span>
                                <p class="font-body text-on-surface-variant">Pense nas peças como algo que você compraria para seus pequenos.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- CTA Section: Tonal Layering -->
        <section class="px-6 pb-24">
            <div class="max-w-5xl mx-auto bg-secondary-container rounded-xl p-12 md:p-20 text-center relative overflow-hidden">
        <!--<div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32">ashidhaish</div>-->
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-primary/10 rounded-full -ml-24 -mb-24"></div>
            <h2 class="font-headline text-4xl md:text-5xl font-extrabold text-on-secondary-container mb-6 relative z-10">Pronta pra desapegar e criar novos vínculos?</h2>
            <p class="font-body text-on-secondary-container/80 text-lg mb-10 max-w-2xl mx-auto relative z-10">
                Entre pro time de mães e pais que praticam consumo consciente e dê ao guarda-roupa do seu pequeno um novo capítulo.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center items-center relative z-10">
                <a class="text-decoration-none" href="https://wa.me/xxxxxxxxxx">
                    <button class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-10 py-[1.25rem] rounded-full font-headline font-bold text-lg shadow-xl shadow-primary/10 transition-transform duration-200 hover:scale-105 active:scale-95">
                        Quero Vender <span class="material-symbols-outlined text-on-primary" data-icon="chat">chat</span>
                    </button>
                </a>
                <a class="text-decoration-none" href="/perguntasfrequentes">
                    <button class="bg-noninha-secondary text-on-primary px-10 py-[1.25rem] rounded-full font-headline font-bold text-lg hover:bg-primary-container transition-colors">
                        Tenho Dúvidas
                    </button>
                </a>
                </div>
        </div>
        </section>
    </main>
</template>

<script>
export default {

}
</script>

<style>

</style>