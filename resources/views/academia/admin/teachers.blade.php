@extends("academia.layout.app")

@section("content")
<div>
    <header class="text-end my-4">
        <a class="btn btn--primary" href="/admin/profesores/agregar">
            <span class="roboto-bold text-white_p">+ Agregar</span>
        </a>
    </header>
    <main>
        <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Cátedras</th>
                    <th class="py-2">No. Estudiantes</th>
                    <th class="py-2">Monto</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr class="roboto-regular text-center text-lg">
                    <td>{{ $teacher->name }} {{ $teacher->last_name }}</td>
                    <td>{{$teacher->courses}}</td>
                    <td></td>
                    <td></td>
                    <td class="flex justify-center py-2">
                        <a href="/admin/profesores/editar/{{ $teacher->id }}" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
                            <img src="{{ asset('img/icons/edit.png') }}" alt="edit" class="w-6">
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</div>
@endsection