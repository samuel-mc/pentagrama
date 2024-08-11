@extends("website.layout.app")

@section("content")
<main>
    <section class="text-center max-w-7xl mx-auto">
        <h2 class="text-4xl text-purple_p not-serif-bold my-5 mb-10">Acerca de nosotros</h2>
    </section>
    <section class="bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 px-6 py-8">
            <div class="text-center px-4 py-2">
                <h3 class="not-serif-bold text-2xl mb-6">Misión</h3>
                <p class="roboto-regular text-xl">
                    Formar a niños, jóvenes y adultos en la ejecución de insturmentos musicales y el canto.
                </p>
            </div>
            <div class="text-center px-4 py-2">
                <h3 class="not-serif-bold text-2xl mb-6">Visión</h3>
                <p class="roboto-regular text-xl">
                    Ser una Academia de música reconocida en nuestra nación y de forma internacional.
                </p>
            </div>
        </div>
    </section>
    <section class="bg-purple_p px-4 py-10">
        <h3 class="not-serif-bold text-3xl text-white_p max-w-6xl mx-auto">La música es para expresar sentir y disfrutar lo que sentimos o queremos hacer sentir.</h3>
    </section>

</main>
@endsection