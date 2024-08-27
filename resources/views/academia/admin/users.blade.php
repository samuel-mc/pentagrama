@extends("academia.layout.app")

@section("content")
<div>
    <table class="w-full">
        <thead class="border-b-2 border-b-light_pink">
            <tr class="roboto-bold text-lg">
                <th class="py-2">Nombre</th>
                <th class="py-2">Tipo</th>
                <th class="py-2">Correo</th>
                <th class="py-2">Ultima conexión</th>
                <!-- <th class="py-2">Acciones</th>f -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="roboto-regular text-center text-lg">
                <td>
                    @if ($user->personal)
                        {{ $user->personal->name }} {{ $user->personal->last_name }}
                    @elseif ($user->student)
                        {{ $user->student->name }} {{ $user->student->last_name }}
                    @elseif ($user->teacher)
                        {{ $user->teacher->name }} {{ $user->teacher->last_name }}
                    @endif
                </td>
                <td>
                    @if ($user->personal)
                        Administrador
                    @elseif ($user->student)
                        Estudiante
                    @elseif ($user->teacher)
                        Profesor
                    @endif
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ $user->last_login }}
                </td>
                <!-- <td class="flex justify-center py-2">
                    <a href="/admin/profesores/editar/{{ $user->id }}" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
                        <img src="{{ asset('img/icons/edit.png') }}" alt="edit" class="w-6">
                    </a>
                </td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection