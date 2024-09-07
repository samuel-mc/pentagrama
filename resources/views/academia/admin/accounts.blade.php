@extends("academia.layout.app")

@section("content")
<header>
    <form action="{{route('admin.cuentas')}}" method="get">
    <div class="flex justify-between items-end">
            <div class="mx-2 my-2 w-full">
                <h3 class="text-sm mb-1 text-light_pink">Nombre</h3>
                <input type="text" name="search" class="input w-full" value="{{$searchValue}}">
            </div>
            <div class="mx-2 my-2">
                <button type="submit" class="btn btn--primary">Buscar</button>
            </div>
        </div>
    </form>
</header>
<main>
    <table class="w-full">
        <thead class="border-b-2 border-b-light_pink">
            <tr class="roboto-bold text-lg">
                <th class="py-2">Nombre</th>
                <th class="py-2">Apellidos</th>
                <th class="py-2">Representante</th>
                <th class="py-2">Cátedras</th>
                <th class="py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if (count($students) == 0)
            <tr class="roboto-regular text-center text-lg">
                <td colspan="5" class="py-2">No se encontraron resultados</td>
            </tr>
            @else
            @foreach($students as $student)
            <tr class="roboto-regular text-center text-lg">
                <td>{{ $student->name }}</td>
                <td>{{$student->last_name}}</td>
                <td>{{$student->representative->name}} {{$student->representative->last_name}}</td>
                <td>{{$student->courses}}</td>
                <td class="flex justify-center py-2">
                    <a href="{{route("admin.cuentas.detalle", ['id'=>$student->id])}}" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
                        <img src="{{ asset('img/icons/see.png') }}" alt="edit" class="w-6">
                    </a>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

</main>

@endsection
