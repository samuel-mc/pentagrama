@extends("academia.layout.app")

@section("content")
    <div>
        <section>
            <h2 class="text-xl">Horario: {{$dayName}}</h2>
            @foreach($groups as $group)
                {{$group->schedules}}
            @endforeach
        </section>
    </div>
@endsection
