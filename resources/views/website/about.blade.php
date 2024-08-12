@extends("website.layout.app")

@section("content")
<main>
    <section class="text-center max-w-7xl mx-auto">
        <h2 class="text-4xl text-purple_p not-serif-bold my-5 mb-10">Acerca de nosotros</h2>
    </section>
    <section class="bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 px-6 py-8">
            <div class="text-center px-4 py-6 border-b-4 md:border-b-0 md:border-r-4 border-dark_pink">
                <h3 class="not-serif-bold text-2xl mb-6">Misión</h3>
                <p class="roboto-regular text-xl">
                    Formar a niños, jóvenes y adultos en la ejecución de insturmentos musicales y el canto.
                </p>
            </div>
            <div class="text-center px-4 py-6">
                <h3 class="not-serif-bold text-2xl mb-6">Visión</h3>
                <p class="roboto-regular text-xl">
                    Ser una Academia de música reconocida en nuestra nación y de forma internacional.
                </p>
            </div>
        </div>
    </section>
    <section class="max-w-7xl mx-auto py-10 px-4">
        <h3 class="not-serif-bold text-4xl text-purple_p my-5 mb-10 text-center">
            ¿Por qué estudiar en pentagrama?
        </h3>
        <p class="text-xl roboto-regular">
            Utilizamos toda la tecnología que está a nuestro alcance para adaptar a cada estudiante el repertorio que necesite logrando un aprendizaje significativo a través de nuna metología en color basada en inteligencias múltiples.
        </p>
    </section>
    @include("components.images")
    <section class="bg-purple_p px-4 py-10">
        <h3 class="not-serif-bold text-3xl text-white_p max-w-6xl mx-auto">La música es para expresar sentir y disfrutar lo que sentimos o queremos hacer sentir.</h3>
    </section>

</main>
@endsection