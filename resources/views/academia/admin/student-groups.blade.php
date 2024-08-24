@extends("academia.layout.app")

@section("content")
<div>
    <header class="text-end my-4">
        <a class="btn btn--primary" href="/admin/estudiantes/{{$id}}/grupos/agregar">
            <span class="roboto-bold text-white_p">+ Agregar</span>
        </a>
    </header>
    <main>
        <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Grupo</th>
                    <th class="py-2">Monto mensual</th>
                    <th class="py-2">Fecha de pago</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupsByStudent as $group)
                <tr class="roboto-regular text-center text-lg">
                    <td>{{$group->group->course->name}} - {{$group->group->age->name}} - {{$group->group->name}}</td>
                    <td>{{$group->monthly_payment}}</td>
                    <td>{{$group->payment_date}}</td>
                    <td class="flex justify-center py-2">
                        <a href="/admin/profesores/editar/{{$id}}" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
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