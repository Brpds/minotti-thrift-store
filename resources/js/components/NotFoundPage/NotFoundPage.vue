<template>
    <main class="pt-[4rem] pb-20 px-8 min-h-screen flex items-center justify-center">
        <div class="max-w-6xl w-full grid md:grid-cols-2 gap-16 items-center">
            <!-- Asymmetric Image Container -->
            <div class="relative order-2 md:order-1">
                <!--
                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-primary-fixed/30 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -right-6 w-48 h-48 bg-secondary-container/20 rounded-full blur-3xl"></div>
                -->
                <div class="w-full relative z-10 rounded-lg overflow-hidden transform rotate-2 hover:rotate-0 transition-transform duration-500 shadow-sm">
                    <img alt="A single vintage leather baby shoe left on a weathered wooden floor" class="w-full aspect-[4/5] object-cover" data-alt="A single miniature vintage brown leather baby shoe sitting alone on a light-colored weathered wooden floor with soft warm morning sunlight" src="https://lh3.googleusercontent.com/aida-public/AB6AXuABKi2NsdMUomYWutHi6CP9p9lWGjtkvNP5V0gYKmLvm9eSkLFQLA5JngTNOgYROWAt-dWR2xW1YtkB-HU_iwfBsAsmshidx6BfEpzb02haNSpIjePJBQNWt4F8n03TZ9sP2GqfbT-zU9LVrwIL98GmOtRZSA5iVFSVQU0xg1XB8is9e_TyCgndAZ7Ydv7eJ8uupbA1ysh9O7cmih47An8nBepBZ1cZKlDI_sK-GWX25h8PqdrkqIiTHAoHy_lF_suuT60Ja1u9bmvw"/>
                </div>
                <!-- Floating Decorative Element -->
                <div class="absolute -bottom-4 -left-4 bg-surface-container-lowest p-6 rounded-lg shadow-sm border border-outline-variant/10 max-w-[200px]">
                    <p class="text-sm font-medium text-tertiary italic">"Things of beauty are never truly lost, just waiting to be found again."</p>
                </div>
            </div>
            <!-- Content Area -->
            <div class="flex flex-col space-y-8 order-1 md:order-2">
                <div class="space-y-4">
                    <span class="text-twprimary font-semibold tracking-widest text-sm uppercase">Não Encontrado</span>
                    <h1 class="text-5xl md:text-6xl font-headline font-extrabold text-on-background tracking-tight leading-tight">
                        Oops! Parece que esta <span class="text-twprimary">peça</span> já foi vendida.
                    </h1>
                    <p class="text-xl text-on-surface-variant font-body leading-relaxed max-w-lg">
                        A página que você procura parece que não está disponível. Não se preocupe, te ajudamos na busca!
                    </p>
                </div>
                <div class="flex flex-wrap gap-4 pt-4">
                    <a class="text-decoration-none px-8 py-4 bg-gradient-to-r from-primary to-primary-container text-on-primary rounded-full font-semibold text-lg hover:scale-105 active:opacity-80 transition-all flex items-center gap-2" href="/">
                        <span class="material-symbols-outlined" data-icon="home">home</span>
                        Página Inicial
                    </a>
                    <a class="text-decoration-none px-8 py-4 bg-surface-container-highest text-on-surface rounded-full font-semibold text-lg hover:scale-105 active:opacity-80 transition-all flex items-center gap-2" href="/vitrine">
                        <span class="material-symbols-outlined" data-icon="grid_view">grid_view</span>
                        Ver todas as Peças
                    </a>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {

}
</script>

<style>

</style>