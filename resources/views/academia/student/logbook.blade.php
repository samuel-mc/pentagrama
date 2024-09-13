@extends("academia.layout.app")

@section("content")
    <table class="w-full">
        <thead class="border-b-2 border-b-light_pink">
        <tr class="roboto-bold text-lg">
            <th class="py-2 text-start">Cátedra</th>
            <th class="py-2 text-start">Fecha</th>
            <th class="py-2 text-start">Tema</th>
            <th class="py-2 text-start">Canciones</th>

            <th class="py-2 text-start">Imagen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logbooks as $logbook)
            <tr class="border-b border-light_pink">
                <td class="py-2">{{$logbook->group->course->name}}</td>
                <td class="py-2">{{$logbook->date}}</td>
                <td class="py-2">{{$logbook->title}}</td>
                <td class="py-2">{{$logbook->song}}</td>
                <td class="py-2">
                    @if($logbook->image)
                        <a href="{{asset('img/users/teachers/logbook/'.$logbook->image)}}" target="_blank">
                            <img src="{{asset('img/users/teachers/logbook/'.$logbook->image)}}" alt="Imagen de bitácora" class="w-10">
                        </a>
                    @else
                        <a href="{{route('admin.profesores.bitacora.agrega-imagen', ['logbookId' => $logbook->id])}}" class="text-purple_p hover:text-dark_pink">
                            Agregar
                        </a>
                    @endif
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
@endsection
