@extends("academia.layout.app")

@section("content")
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
    @foreach($linksAditionalInfo as $infoItem)
    <div>
        <a href="{{$infoItem->url}}" class="flex flex-col items-center justify-center border-2 border-light_pink rounded py-4 px-2 hover:bg-light_pink transition-all">
            <span>
                <img src="{{asset('img/icons/'.$infoItem->icon)}}" alt="icon" class="w-10">
            </span>
            <span>
                <h2 class="text-xl roboto-regular mt-4">{{$infoItem->name}}</h2>
            </span>
        </a>
    </div>
    @endforeach
</div>
@endsection