<template>
    <div>
        <main class="flex-grow flex items-center justify-center px-6 py-6 md:py-12 relative overflow-hidden">
            <!-- Abstract Background Elements -->
            <div class="absolute top-[-10%] left-[-5%] w-72 h-72 bg-secondary-container opacity-20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] right-[-5%] w-96 h-96 bg-primary-container opacity-10 rounded-full blur-3xl"></div>
            <!-- Login Card -->
            <div class="w-full max-w-md z-10">
            <div class="bg-surface-container-lowest rounded-lg p-8 md:p-12 transition-transform duration-300">
            <div class="text-center mb-10">
            <h1 class="font-headline text-primary text-3xl font-extrabold tracking-tight mb-2">Bem vindo(a)!</h1>
            <!--<p class="text-on-surface-variant text-sm font-medium">Continue your journey in conscious childhood.</p>-->
            </div>
            <!-- Form -->
            <form class="space-y-6" method="POST" action="" @submit.prevent="login($event)">
                <input type="hidden" name="_token" :value="csrfToken">
            <div class="space-y-1">
            <label class="text-xs font-bold tracking-widest uppercase text-on-surface-variant ml-1" for="email">Email</label>
            <div class="relative">
            <input v-model="email" class="w-full required bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-twprimary transition-all autofocus" id="email" name="email" placeholder="meu@email.com" required="" type="email"/>
            </div>
            </div>
            <div class="space-y-1">
            <div class="flex justify-between items-center px-1">
            <label class="text-xs font-bold tracking-widest uppercase text-on-surface-variant focus:ring-2 focus:ring-twprimary" for="password">Senha</label>
            <a class="text-xs font-semibold text-secondary hover:underline decoration-secondary" href="#">Esqueceu a Senha?</a>
            </div>
            <div class="relative">
            <input v-model="password" class="w-full bg-surface-variant border-none rounded-DEFAULT px-4 py-4 text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary transition-all required" id="password" name="password" placeholder="••••••••" required="" type="password"/>
            </div>
            </div>
            <button class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold py-4 rounded-full transition-transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-primary/10" type="submit">
                Login
            </button>
            </form>
            <p v-if="loginError" role="alert" class="mt-4 text-danger">{{ loginError }}</p>
            
            <!-- Tonal Info Block (Bento style hint) -->
            <div class="mt-6 bg-secondary-container/30 backdrop-blur-md p-6 rounded-lg flex items-start gap-4">
            <div class="bg-secondary p-2 rounded-full text-on-secondary">
            <span class="material-symbols-outlined text-lg" data-icon="eco">eco</span>
            </div>
            <div>
            <h4 class="font-headline font-bold text-on-secondary-container text-sm">Comprando com Responsabilidade</h4>
            <p class="text-on-secondary-container/80 text-xs leading-relaxed mt-1">Cada compra que você faz diminui o impacto ambiental enquanto reforça nosso compromisso com o bem estar dos nossos pequenos.</p>
            </div>
            </div>
            </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    props:['csrfToken'],
    methods:{
        login(e){
            this.loginError = '';
            let url = '/api/login';
            let configuracao = {
                method: 'post',
                headers: { 'Accept': 'application/json' },
                body: new URLSearchParams({
                    'email' : this.email,
                    'password' : this.password
                })
            }
            fetch(url, configuracao)
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok || !data.token) {
                        throw new Error(data.erro || 'Não foi possível entrar.');
                    }
                    return data;
                })
                .then(data => {
                    if(data.token){
                        document.cookie = 'token='+data.token+';SameSite=Lax'
                    }
                e.target.submit();
                })
                .catch(error => {
                    this.loginError = error.message;
                });
        }
    },
    data(){
        return {
            email: '',
            password: '',
            loginError: '',
        }
    }
}
</script>

<style>

</style>
