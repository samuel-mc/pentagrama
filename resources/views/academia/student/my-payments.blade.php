@extends('academia.layout.app')

@section('content')
    <div>
        <header class="text-end my-4">
            <a class="btn btn--primary" href="{{route('admin.estudiantes.pagos.agregar')}}">
                <span class="roboto-bold text-white_p">+ Agregar</span>
            </a>
        </header>
        <main>
            <table class="w-full">
                <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Fecha</th>
                    <th class="py-2">Método</th>
                    <th class="py-2">Tipo</th>
                    <th class="py-2">Monto pagado</th>
                    <th class="py-2">Grupo</th>
                    <th class="py-2">Capture</th>
                    <td class="py-2">Validado</td>
                </tr>
                </thead>
                <tbody>
                @foreach($myPayments as $payment)
                    <tr class="roboto-regular text-center text-lg">
                        <td class="py-2">{{ $payment->parsedCreatedAt}}</td>
                        <td class="py-2">{{ $payment->method->name}}</td>
                        <td class="py-2">{{$payment->type->name}}</td>
                        <td class="py-2">{{$payment->amount_paid}}$</td>
                        <td class="py-2">@isset($payment->group->name){{$payment->group->name}}@endisset</td>
                        <td class="py-2">
                            <a href="{{asset('img/users/students/payments/'.$payment->voucher)}}" target="_blank" class="text-purple_p hover:text-dark_pink">
                                Ver
                            </a>
                        </td>
                        <td class="py-2">
                            @if($payment->accepted)
                                <img src="{{asset('img/icons/accepted.png')}}" alt="check" class="w-6 h-6">
                            @else
                                <img src="{{asset('img/icons/noAccepted.png')}}" alt="check" class="w-6 h-6">
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </main>
    </div>
@endsection
