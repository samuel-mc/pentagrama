<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pentragrama - Academia de música</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    @if($getSplide)
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    @endif
    @vite('resources/css/app.css')
</head>

<body class="bg-white_p relative">
    <!-- Header desktop -->
    <header class="bg-white_p py-2 px-1 hidden lg:block shadow">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between border-b-2 pb-4 border-purple_p">
                <a href="">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-100 max-w-12">
                </a>
                <div>
                    @include("components.btn_primary", ["path" => "/contacto", "text" => "Contactános"])
                </div>
            </div>
            <div class="py-4">
                <ul class="flex text-black_p text-xl not-serif-regular italic place-content-center">
                    <li class="menu--item">
                        <a href="/home">Inicio</a>
                    </li>
                    <li class="menu--item">
                        <a href="/#catedras">Cátedras</a>
                    </li>
                    <li class="menu--item">
                        <a href="/about">Nosotros</a>
                    </li>
                    <li class="menu--item">
                        <a href="/faq">Preguntas frecuentes</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- Header mobile -->
    <header class="bg-white_p block lg:hidden shadow sticky top-0 z-20">
        <div class="px-6 py-4 flex justify-between items-center border-b-2 border-b-dark_pink ">
            <div>
                <a href="">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-100 max-w-12">
                </a>
            </div>
            <div>
                <button id="menu--button" class="text-white_p">
                    <img id="showMenu" src="{{ asset('img/icons/menu.png') }}" alt="menu" class="w-6">
                    <img id="closeMenu" src="{{ asset('img/icons/close.png') }}" alt="close menu" class="w-6 hidden">

                </button>
            </div>
        </div>
        <div id="menu--content" class="bg-white_p shadow-lg py-4 px-4 hidden">
            <ul class="flex flex-col text-white_p text-lg not-serif-regular">
                <li class="my-2">
                    <a class="text-black_p hover:text-light_pink transition-all" href="/home">Inicio</a>
                </li>
                <li class="my-2">
                    <a class="text-black_p hover:text-light_pink transition-all" href="/#catedras">Cátedras</a>
                </li>
                <li class="my-2">
                    <a class="text-black_p hover:text-light_pink transition-all" href="/about">Nosotros</a>
                </li>
                <li class="my-2">
                    <a class="text-black_p hover:text-light_pink transition-all" href="/faq">Preguntas frecuentes</a>
                </li>
            </ul>
        </div>
    </header>


    @yield('content')
    <footer class="bg-white_p py-4 border-b-8 border-b-purple_p">
        <div class="max-w-7xl mx-auto p-4">
            <div class="text-center border-b-2 border-purple_p">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="w-8 mx-auto">
                <div class="my-4">
                    <h3 class="text-dark_pink text-xl audiowide-regular">PENTAGRAMA</h3>
                    <h6 class="text-purple_p text-lg not-serif-bold">Academia de música</h6>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-center md:justify-between">
                <div class="my-6">
                    <ul class="flex">
                        <li class="mx-2">
                            <a href="" class="opacity-75 hover:opacity-100 transition-all">
                                <img src="{{ asset('img/icons/fb.png') }}" alt="facebook" class="w-7">
                            </a>
                        </li>
                        <li class="mx-2">
                            <a href="" class="opacity-75 hover:opacity-100 transition-all">
                                <img src="{{ asset('img/icons/ig.png') }}" alt="Instagram" class="w-7">
                            </a>
                        </li>
                        <li class="mx-2">
                            <a href="" class="opacity-75 hover:opacity-100 transition-all">
                                <img src="{{ asset('img/icons/x.png') }}" alt="X" class="w-7">
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="text-xl flex-col md:flex-row not-serif-regular flex text-center">
                        <li class="mx-2">
                            <a class="text-black_p_75 hover:text-black_p transition-all" href="/home">Inicio</a>
                        </li>
                        <li class="mx-2">
                            <a class="text-black_p_75 hover:text-black_p transition-all" href="/#catedras">Cátedras</a>
                        </li>
                        <li class="mx-2">
                            <a class="text-black_p_75 hover:text-black_p transition-all" href="/about">Nosotros</a>
                        </li>
                        <li class="mx-2">
                            <a class="text-black_p_75 hover:text-black_p transition-all" href="">Preguntas frecuentes</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </footer>
</body>

<script>
    const menuButton = document.getElementById('menu--button');
    const menuContent = document.getElementById('menu--content');
    const showMenu = document.getElementById('showMenu');
    const closeMenu = document.getElementById('closeMenu');

    menuButton.addEventListener('click', () => {
        menuContent.classList.toggle('hidden');
        showMenu.classList.toggle('hidden');
        closeMenu.classList.toggle('hidden');
    });
</script>

</html>