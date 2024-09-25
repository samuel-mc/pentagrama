@extends('academia.layout.app')

@section('content')
    <header>
        <div class="my-4">
            <table class="text-center mx-auto">
                <tr class="bg-purple_p text-white_p text-lg">
                    <td>Próximo evento</td>
                </tr>
                <tr class="text-lg border border-black_p border-t-0">
                    <td>Recital y entrega de certificado 10/01/24</td>
                </tr>
            </table>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 my-4">
            <table class="text-center">
                <tr class="bg-purple_p text-white_p text-lg">
                    <td>Última clase</td>
                </tr>
                <tr class="text-lg border border-black_p border-t-0">
                    <td>{{$lastScheduleDated['date']}}</td>
                </tr>
            </table>
            <table class="text-center">
                <tr class="bg-purple_p text-white_p text-lg">
                    <td>Próxima clase</td>
                </tr>
                <tr class="text-lg border border-black_p border-t-0">
                    <td>{{$nextScheduleDated['date']}}</td>
                </tr>
            </table>
            @foreach($paymentDates as $payment)
                <div class="col-span-1 sm:col-span-2">
                    <h2 class="text-center text-purple_p uppercase">{{$payment->course}}</h2>

                    <div class="grid grid-cols-2 gap-4">
                        <table class="text-center">
                            <tr class="bg-purple_p text-white_p text-lg">
                                <td>Fecha de pago</td>
                            </tr>
                            <tr class="text-lg border border-black_p border-t-0">
                                <td>{{$payment->paymenDateFormated}}</td>
                            </tr>
                        </table>
                        <table class="text-center">
                            <tr class="bg-purple_p text-white_p text-lg">
                                <td>Monto</td>
                            </tr>
                            <tr class="text-lg border border-black_p border-t-0">
                                <td>{{$payment->amount}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </header>
    <main>
        <table class="w-full">
            <thead class="border-b-2 border-purple_p">
            @foreach($days as $day)
                <th class="text-lg text-purple_p py-2">{{$day}}</th>
            @endforeach
            </thead>
            <tbody>
            @foreach($scheduleByStudent as $key => $hours)
                <tr class="border-b-2 border-light_pink">
                    <td class="py-2 text-center"
                        style="border-left: 1px solid #00000075; border-right: 1px solid #00000075">
                        {{$key}}
                    </td>
                    @foreach($hours as $item)
                        @if($item != null)
                            <td class="py-2 text-center"
                                style="border-left: 1px solid #00000075; border-right: 1px solid #00000075">
                                {{$item->name}}
                            </td>
                        @else
                            <td class="py-2 text-center text-green-700"
                                style="border-left: 1px solid #00000075; border-right: 1px solid #00000075">
                                Disponible
                            </td>

                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </main>
@endsection
