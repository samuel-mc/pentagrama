@extends("website.layout.app")

@section("content")
<main class="bg--pattern">
    <section class="max-w-7xl mx-auto">
        <div class="my-16">
            <h2 class="text-4xl text-purple_p not-serif-bold text-center">Preguntas frecuentes</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
            @foreach($faqs as $faq)
                <div class="bg-white shadow-md px-6 py-8 rounded-lg">
                    <h3 class="text-3xl text-purple_p not-serif-bold mb-2">{{ $faq->question }}</h3>
                    <p class="text-lg text-black_p roboto-regular">{{ $faq->answer}}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection
