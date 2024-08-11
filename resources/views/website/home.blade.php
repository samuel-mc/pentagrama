@extends("website.layout.app")

@section("content")
<main>
    <!-- Hero -->
    <section class="relative">
        <div class="absolute z-10 bg-black_p_75 w-full h-full flex items-center justify-center py-4 px-8">
            <div class="max-w-7xl text-center">
                <h2 class="text-2xl sm:text-5xl lg:text-7xl not-serif-regular text-white_p md:text-light_pink">Aprende, crea y crece en nuestra academia de música.</h2>
                <p class="text-white roboto-regular text-xl my-10 hidden md:block">
                    Ofrecemos clases para todas las edades y niveles. Desde principiantes hasta avanzados, te ayudamos a alcanzar tus metas musicales con programas personalizados y profesores experimentados
                </p>
                <div class="w-fit mx-auto mt-6">
                    @include("components.btn_primary", ["path" => "/contacto", "text" => "Agenda tu clase"])
                </div>
            </div>
        </div>
        <div class="splide" aria-label="Splide Basic HTML Example">
            <div class="splide__track">
                <ul class="splide__list">
                    @for($i = 1; $i < 8; $i++) <li class="splide__slide">
                        <img src="{{ asset('img/img' . $i . '.jpg') }}" alt="logo" class="w-full aspect-video object-cover">
                        </li>
                        @endfor
                </ul>
            </div>
    </section>

    <!-- Cursos -->
    <section class="max-w-7xl mx-auto py-10 px-6">
        <header class="text-center">
            <h2 class="text-4xl text-purple_p not-serif-bold my-5 mb-10">Nuestras cátedras</h2>
        </header>
        <main class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-10">
            @foreach($courses as $course)
            <div class="text-center rounded border border-purple_p shadow py-4 sm:py-12 px-2">
                <div>
                    <img src="{{ asset('img/' . $course->img )}}" alt="{{$course->title}}" class="h-20 rounded mx-auto">
                </div>
                <h3 class="roboto-medium text-2xl my-4 text-black_p">{{$course->title}}</h3>
            </div>
            @endforeach

        </main>
    </section>

    <!-- Metodologia -->
    <section class="bg-white">
        <div class="max-w-7xl mx-auto py-10 px-6">
            <header class="text-center">
                <h2 class="text-4xl text-purple_p not-serif-bold my-5 mb-10">Metodología</h2>
            </header>
            <main>
                <ul class="flex flex-col md:flex-row justify-between flex-wrap">
                    <li class="flex items-center w-fit my-2">
                        <img src="{{ asset('img/icons/corchea.png') }}" alt="corazon" class="w-4 mx-auto h-4 mr-1">
                        <p class="text-xl text-black_p not-serif-regular">En color</p>
                    </li>
                    <li class="flex items-center w-fit my-2">
                        <img src="{{ asset('img/icons/corchea.png') }}" alt="corazon" class="w-4 mx-auto h-4 mr-1">
                        <p class="text-xl text-black_p not-serif-regular">Personalizadas</p>
                    </li>
                    <li class="flex items-center w-fit my-2">
                        <img src="{{ asset('img/icons/corchea.png') }}" alt="corazon" class="w-4 mx-auto h-4 mr-1">
                        <p class="text-xl text-black_p not-serif-regular">Adaptamos canciones</p>
                    </li>
                    <li class="flex items-center w-fit my-2">
                        <img src="{{ asset('img/icons/corchea.png') }}" alt="corazon" class="w-4 mx-auto h-4 mr-1">
                        <p class="text-xl text-black_p not-serif-regular">2 clases semanales</p>
                    </li>
                </ul>
            </main>
        </div>

    </section>

    <!-- Images -->
    <section>
        <div class="grid grid-cols-2 lg:grid-cols-4">
            @for($i = 1; $i <= 8; $i++) <img src="{{ asset('img/img' . $i . '.jpg') }}" alt="img{{ $i }}" class="w-full aspect-video object-cover">
                @endfor
        </div>
    </section>

    <!-- Contact -->
    <section class="bg-purple_p px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl text-white_p not-serif-regular text-center mb-6">Contacto</h2>
            <form action="">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 gap-y-3">
                    <!-- Input -->
                    <div class="flex flex-col">
                        <label for="nombre" class="text-lg text-white_p not-serif-regular">Nombre del estudiante*</label>
                        <input type="text" placeholder="Juan" class="w-100 rounded px-2 py-1 bg-white_p roboto-regular" id="nombre">
                    </div>
                    <div class="flex flex-col">
                        <label for="apellido" class="text-lg text-white_p not-serif-regular">Apellido del estudiante*</label>
                        <input type="text" placeholder="Lopéz" class="w-100 rounded px-2 py-1 bg-white_p roboto-regular" id="apellido">
                    </div>
                    <div class="flex flex-col">
                        <label for="nombreRepresentante" class="text-lg text-white_p not-serif-regular">Nombre del representante *</label>
                        <input type="text" placeholder="Diego" class="w-100 rounded px-2 py-1 bg-white_p roboto-regular" id="nombreRepresentante">
                    </div>
                    <div class="flex flex-col">
                        <label for="apellido" class="text-lg text-white_p not-serif-regular">Apellido del representante*</label>
                        <input type="text" placeholder="Verón" class="w-100 rounded px-2 py-1 bg-white_p roboto-regular" id="apellidoRepresentante">
                    </div>
                    <div class="flex flex-col">
                        <label for="nombre" class="text-lg text-white_p not-serif-regular">Teléfono *</label>
                        <input type="tel" placeholder="1234567890" class="w-100 rounded px-2 py-1 bg-white_p roboto-regular" id="nombre">
                    </div>
                    <div>
                        <label for="email" class="text-lg text-white_p not-serif-regular">¿Cómo se enteró de nuestra academia?</label>
                        <select name="como" id="como" class="w-full rounded px-2 py-2 bg-white_p roboto-regular">
                            <option value="" selected>Selecciona una opción</option>
                            <option value="me_lo_contaron">Me lo contaron</option>
                            <option value="instagram">Instagram</option>
                            <option value="whatsapp">Whatsapp</option>
                            <option value="facebook">Facebook</option>
                            <option value="radio">Radio</option>
                            <option value="youtube">YouTube</option>
                            <option value="evento_publico">Evento Público</option>
                        </select>
                    </div>
                </div>
                <div class="my-10">
                    <button type="button" class="bg-light_pink hover:bg-dark_pink transition-all rounded font-bold roboto-medium text-white_p text-lg py-3 px-6 block w-full">
                        Enviar
                    </button>
                </div>
            </form>
        </div>

    </section>

    <!-- Ubicacion -->
    <section class="bg-white px-6 py-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
            <div>
                <img src="{{ asset('img/ubi.png') }}" alt="logo" class="w-full rounded">
                <h3 class="text-2xl not-serif-bold my-4 text-center">
                    Centro Empresarial "La Colmena". 3er piso. Local 304.
                </h3>
                <p class="not-serif-bold text-lg">
                    Av. Gonzalo Picón y Viducto Miranda.
                </p>
                <p class="not-serif-bold text-lg">
                    En frente del "Cubo Rojo"
                </p>
                <p class="not-serif-bold text-lg">
                    Horario de atención: Lunes a Viernes de 2:30pm a 4:30pm
                </p>
            </div>
            <div class="h-full">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d414.67575533385406!2d-71.15476666414143!3d8.588031080949596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e648793f9272d2f%3A0xdf9795834d62f3c7!2sPentagrama%20Academia%20de%20M%C3%BAsica!5e0!3m2!1ses-419!2smx!4v1723138514351!5m2!1ses-419!2smx" style="border:0; min-height: 240px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="mx-auto w-full h-full"></iframe>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
    const splide = new Splide('.splide', {
        type: 'loop',
        perPage: 1,
        perMove: 1,
        gap: '1rem',
        pagination: false,
        autoplay: true,
        breakpoints: {
            640: {
                perPage: 1,
            },
            768: {
                perPage: 1,
            }
        }
    }).mount();
</script>
@endsection