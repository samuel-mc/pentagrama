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
            <thead>
                <tr class="roboto-bold text-lg">
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cátedras</th>
                    <th>No. Estudiantes</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr class="roboto-regular text-center text-lg">
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->last_name }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="/admin/profesores/editar/{{ $teacher->id }}" class="btn btn--secondary">Editar</a>
                        <a href="/admin/profesores/eliminar/{{ $teacher->id }}" class="btn btn--danger">Eliminar</a>
                    </td>
                @endforeach
            </tbody>
        </table>
    </main>
</div>
@endsection