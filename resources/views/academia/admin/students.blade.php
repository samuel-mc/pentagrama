@extends("academia.layout.app")

@section("content")
<div>
    <header class="text-end my-4">
        <a class="btn btn--primary" href="/admin/inscripcion">
            <span class="roboto-bold text-white_p">+ Agregar</span>
        </a>
    </header>
    <main>
        <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2 px-2"></th>
                    <th class="py-2 px-2">Estudiante</th>
                    <th class="py-2 px-2">Representante</th>
                    <th class="py-2 px-2">Cátedra</th>
                    <th class="py-2 px-2">Monto</th>
                    <th class="py-2 px-2">Fecha de pago</th>
                    <th class="py-2 px-2">Modalidad</th>
                    <th class="py-2 px-2">Horario</th>
                    <th class="py-2 px-2">Estado</th>
                    <th class="py-2 px-2">Fecha de ingreso</th>
                    <th class="py-2 px-2">Ficha inscripción</th>
                    <th class="py-2 px-2">Bitácora</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $key => $student)
                <tr class="roboto-regular text-center text-lg">
                    <td class="py-1 px-2">{{ $key + 1 }}</td>
                    <td class="py-1 px-2">{{ $student->name }} {{ $student->last_name }}</td>
                    <td class="py-1 px-2">{{ $student->representative->name }} {{ $student->representative->last_name }}</td>
                    <td class="py-1 px-2">Catedra</td>
                    <td class="py-1 px-2">${{ $student->paymentsData->monthly_payment }}</td>
                    <td class="py-1 px-2">{{ $student->formatedPaymentDate }}</td>
                    <td class="py-1 px-2">{{ $student->modality }}</td>
                    <td class="py-1 px-2">12:00</td>
                    <td class="py-1 px-2 {{ $student->active ? "text-green-500" : "text-red-500" }}">{{ $student->active ? "Activo" : "Inactivo" }}</td>
                    <td class="py-1 px-2">{{ $student->formattedCreatedAt }}</td>
                    <td class="py-1 px-2">
                        <a href="#" class="text-dark_pink hover:text-purple_p transition-all">
                            Ver
                        </a>
                    </td>
                    <td class="py-1 px-2">
                        <a href="#" class="text-dark_pink hover:text-purple_p transition-all">
                            Ver
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</div>
@endsection