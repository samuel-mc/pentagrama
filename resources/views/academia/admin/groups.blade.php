@extends("academia.layout.app")

@section('content')
<div>
    <section>
        <a href="/admin/grupos/agregar" class="btn btn--primary font-bold">+ Agregar
        </a>
    </section>
    <section class="my-4">
        <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Profesor</th>
                    <th class="py-2">Cátedra</th>
                    <th class="py-2">Categorías</th>
                    <th class="py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $group)
                <tr class="roboto-regular text-center text-lg">
                    <td>{{ $group->name}}</td>
                    <td>{{$group->teacher->name}} {{$group->teacher->last_name}}</td>
                    <td>{{$group->course->name}}</td>
                    <td class="flex justify-center py-2">
                        <a href="/admin/profesores/editar" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
                            <img src="{{ asset('img/icons/edit.png') }}" alt="edit" class="w-6">
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>
@endsection