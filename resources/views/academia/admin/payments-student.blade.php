@extends("academia.layout.app")

@section("content")
<div>
    <div>
        <a href="/admin/estudiantes/{{$student->id}}/pagos/agregar">
            <button class="bg-purple_p text-white rounded-md px-8 py-2">Nuevo pago</button>
        </a>
    </div>
    @if(count($pagos) > 0)
    <div class="my-4">
    <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Tipo</th>
                    <th class="py-2">Fecha de pago</th>
                    <th class="py-2">Monto pagado</th>
                    <th class="py-2">Monto pendiente</th>
                    <th class="py-2">Tasa en bs</th>
                    <th class="py-2">Pagar antes del</th>
                    <th class="py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagos as $pago)
                <tr class="roboto-regular text-center text-lg">
                    <td>{{$pago->studentPaymentType->name}}</td>
                    <td>{{$pago->date}}</td>
                    <td>{{$pago->amountPaid}}</td>
                    <td>{{$pago->amountDue}}</td>
                    <td>{{$pago->rate}}</td>
                    <td class="text-red-500"><span @class(["hidden"  => $pago->is_paid])>{{$pago->due_date}}</span></td>
                    <td class="flex justify-center py-2">
                        <a href="/admin/estudiantes/pagos/detalle/{{$pago->id}}" class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
                            <img src="{{ asset('img/icons/see.png') }}" alt="edit" class="w-6">
                        </a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="my-4">
        <h1 class="text-xl roboto-regular text-center">No hay pagos registrados</h1>
    </div>
    @endif

</div>
@endsection