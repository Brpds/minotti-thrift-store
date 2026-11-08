<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Minotti Noninha') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="/favicon.png" type="image/favicon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
</head>
<body>
    <div id="app">
        <!-- TopNavBar (old color: #fff8f3/20) -->
        <nav class="fixed top-0 w-full z-50 bg-[#d087cb]/40 backdrop-blur-md shadow-sm shadow-[#251a05]/5">
        <div class="flex justify-between items-center w-full px-8 py-3 max-w-7xl mx-auto">
        
            
            <!-- Left side -->
            <a class="text-decoration-none" href="/">
                <div class="flex items-center gap-6">
                <!--<img class="h-8 w-auto object-contain" src="/storage/imagens/logo/LOGO_png.png" />-->
                <span class="text-2xl font-label font-bold tracking-tight text-[#d087cb]">
                    Minotti <span class="text-2xl font-bold tracking-tight text-[#88a0cf]">Noninha</span>
                </span>
                </div>
            </a>

            <!-- Desktop menu -->
            <div class="hidden md:flex gap-6 items-center">
                <a class="font-headline cursor-pointer text-decoration-none tracking-tight transition-opacity duration-300 text-sm font-medium text-[#88a0cf] link-hover" href="{{ route('vitrine') }}">Explorar</a>
                <a class="font-headline cursor-pointer text-decoration-none tracking-tight transition-opacity duration-300 text-sm font-medium text-[#88a0cf] link-hover" href="{{ route('vendaconosco') }}">Venda Conosco</a>
                <a class="font-headline cursor-pointer text-decoration-none tracking-tight transition-opacity duration-300 text-sm font-medium text-[#88a0cf] link-hover" href="{{ route('sobrenos') }}">Sobre Nós</a>
                <a class="font-headline cursor-pointer text-decoration-none tracking-tight transition-opacity duration-300 text-sm font-medium text-[#88a0cf] link-hover" href="{{ route('perguntasfrequentes') }}">Dúvidas</a>
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-3 text-[#d087cb]">
            @guest
                @if (Route::has('login'))
                <a href="{{ route('login') }}" class="text-headline text-decoration-none text-[#d087cb] text-sm my-auto font-medium hover:text-[#54433b]">
                    <span class="material-symbols-outlined">person</span>
                </a>
                @endif
            @else
                <!-- Dropdown -->
                <div class="relative">
                <button class="flex items-center gap-2 text-sm font-medium hover:text-[#54433b]" onclick="toggleDropdown()">
                    {{ Auth::user()->nome }}
                    <span class="material-symbols-outlined">arrow_drop_down</span>
                </button>
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md">
                    <a class="text-headline text-decoration-none block px-4 py-2 text-sm link-hover hover:bg-[#f3e9f8]" href="{{ route('home') }}">Perfil</a>
                    <a class="text-headline text-decoration-none block px-4 py-2 text-sm link-hover hover:bg-[#f3e9f8]" href="{{ route('usuarios') }}">Usuários</a>
                    <a class="text-headline text-decoration-none block px-4 py-2 text-sm link-hover hover:bg-[#f3e9f8]" href="{{ route('produtos') }}">Produtos</a>
                    <a class="text-headline text-decoration-none block px-4 py-2 text-sm link-hover hover:bg-[#f3e9f8]" href="{{ route('fornecedores') }}">Fornecedores</a>
                    <a class="text-headline text-decoration-none block px-4 py-2 text-sm link-hover hover:bg-[#f3e9f8]" href="{{ route('marcas') }}">Marcas</a>
                    <a class="text-headline text-decoration-none block px-4 py-2 text-sm link-hover hover:bg-[#f3e9f8]" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
                </div>
            @endguest

            <!-- Hamburger for mobile -->
            <button id="hamburgerBtn" class="md:hidden active:scale-95" onclick="toggleSidebar()">
                <span class="material-symbols-outlined">Menu</span>
            </button>
            </div>
        </div>
        </nav>

        <!-- Sidebar -->
        <div id="mobileSidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="p-6 flex flex-col gap-4">
            <a class="text-headline text-sm text-decoration-none font-medium text-[#54433b] link-hover" href="{{ route('vitrine') }}">Explorar</a>
            <a class="text-headline text-sm text-decoration-none font-medium text-[#54433b] link-hover" href="{{ route('vendaconosco') }}">Venda Conosco</a>
            <a class="text-headline text-sm text-decoration-none font-medium text-[#54433b] link-hover" href="{{ route('sobrenos')}}">Sobre Nós</a>
            <a class="text-headline text-sm text-decoration-none font-medium text-[#54433b] link-hover" href="{{ route('perguntasfrequentes') }}">Dúvidas</a>
            
            @guest
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="text-headline link-hover text-decoration-none text-sm font-medium hover:text-[#54433b]">
                Login
                </a>
            @endif
            @else
            <a class="text-sm font-medium link-hover text-headline text-decoration-none" href="{{ route('home') }}">Perfil</a>
            <a class="text-sm font-medium link-hover text-headline text-decoration-none" href="{{ route('usuarios') }}">Usuários</a>
            <a class="text-sm font-medium link-hover text-headline text-decoration-none" href="{{ route('produtos') }}">Produtos</a>
            <a class="text-sm font-medium link-hover text-headline text-decoration-none" href="{{ route('fornecedores') }}">Fornecedores</a>
            <a class="text-sm font-medium link-hover text-headline text-decoration-none" href="{{ route('marcas') }}">Marcas</a>
            <a class="text-sm font-medium link-hover text-headline text-decoration-none" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            @endguest
        </div>
        </div>

        <main class="py-4 mt-5">
            @yield('content')
        </main>
    </div>
    
    <!-- Footer oldColor: bg-[#fff2e1] -->
    <footer class="w-full overflow-x-auto rounded-t-[1.5rem] bg-[#d087cb]/40">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 px-12 py-16 max-w-7xl mx-auto text-center md:text-left">
    <div>
    <span class="text-lg font-bold text-[#54433b] block mb-6">Minotti Noninha</span>
    <p class="font-headline text-xs uppercase tracking-widest text-[#54433b] opacity-70 leading-relaxed">
        Um espaço dedicado a tesouros infantis escolhidos com carinho. Consumo consciente para um futuro mais gentil.
    </p>
    </div>
    <div class="grid grid-cols-2 gap-8">
    <div class="flex flex-col gap-4">
    <a class="font-headline text-decoration-none text-xs uppercase tracking-widest text-[#54433b] opacity-70 hover:text-[#95491b] transition-colors" href="https://wa.me/xxxxxxxxxxxx">Política de Privacidade</a>
    <a class="font-headline text-decoration-none text-xs uppercase tracking-widest text-[#54433b] opacity-70 hover:text-[#95491b] transition-colors" href="https://wa.me/xxxxxxxxxxxx">Termos de Serviço</a>
    <a class="font-headline text-decoration-none text-xs uppercase tracking-widest text-[#54433b] opacity-70 hover:text-[#95491b] transition-colors" href="https://wa.me/xxxxxxxxxxxx">Entregas &amp; Devoluções</a>
    </div>
    <div class="flex flex-col gap-4">
    <a class="font-headline text-xs text-decoration-none uppercase tracking-widest text-[#54433b] opacity-70 hover:text-[#95491b] transition-colors" href="https://wa.me/xxxxxxxxxxxx">Contate-nos</a>
    <a class="font-headline text-xs text-decoration-none uppercase tracking-widest text-[#54433b] opacity-70 hover:text-[#95491b] transition-colors" href="http://instagram.com/">Instagram</a>
    <!--<a class="font-headline text-xs text-decoration-none uppercase tracking-widest text-[#54433b] opacity-70 hover:text-[#95491b] transition-colors" href="#">Slot Livre</a>-->
    </div>
    </div>
    <div class="flex flex-col md:items-end justify-center">
    <p class="font-headline text-xs uppercase tracking-widest text-[#646109] font-bold">© 2024 Minotti Noninha. Moda Sustentável.</p>
    </div>
    </div>
    </footer>
    
</body>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }


        function toggleSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('mobileSidebar');
            const button = document.getElementById('hamburgerBtn');

            if (
                !sidebar.contains(e.target) &&
                !button.contains(e.target)
            ) {
                sidebar.classList.add('-translate-x-full');
            }
        });
        </script>
</html>
