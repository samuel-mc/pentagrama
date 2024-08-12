<!-- Images -->
<section>
    <div class="grid grid-cols-2 lg:grid-cols-4">
        @for($i = 1; $i <= 8; $i++) <img src="{{ asset('img/img' . $i . '.jpg') }}" alt="img{{ $i }}" class="w-full aspect-video object-cover">
            @endfor
    </div>
</section>