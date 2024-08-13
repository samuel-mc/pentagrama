@extends("academia.layout.app")

@section("content")
<div>
    <header class="text-end my-4">
        <a class="btn btn--primary" href="/admin/info-adicional/como-nos-encontraste/agregar">
            <span class="roboto-bold text-white_p">+ Agregar</span>
        </a>
    </header>
    <main>
        <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Estatus</th>
                    <th class="py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="roboto-regular text-center text-lg">
                    <td>{{ $item->how }}</td>
                    <td>{{ $item->active ? "Activo" : "Inactivo"  }}</td>
                    <td class="flex justify-center py-2">
                        <a href="/admin/info-adicional/como-nos-encontraste/editar/{{ $item->id }}" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
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