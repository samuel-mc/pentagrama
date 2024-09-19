@extends("academia.layout.app")

@section("content")
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <td class="text-red-500">
                                <span @class(["hidden"  => $pago->is_paid])>{{$pago->due_date}}</span></td>
                            <td class="flex justify-center py-2">
                                <a href="/admin/estudiantes/pagos/detalle/{{$pago->id}}"
                                   class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow">
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

        @if(count($paymentsRequest) > 0)
            <section class="w-full my-6">
                <div class="my-4">
                    <h2 class="text-2xl font-bold">Solicitudes de pago</h2>
                </div>
                <div>
                    <table class="w-full overflow-scroll">
                        <thead class="border-b-2 border-b-light_pink">
                        <tr class="roboto-bold text-lg">
                            <th class="py-2">Estudiante</th>
                            <th class="py-2">Representante</th>
                            <th class="py-2">Método de pago</th>
                            <th class="py-2">Monto</th>
                            <th class="py-2">Monto que debio pagar</th>
                            <th class="py-2">Capture</th>
                            <th class="py-2">Fecha</th>
                            <th class="py-2">Validar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paymentsRequest as $paymentRequest)
                            <tr class="roboto-regular text-center text-lg">
                                <td class="py-2">{{$paymentRequest->student->name}}</td>
                                <td class="py-2">{{$paymentRequest->student->representative->name}}</td>
                                <td class="py-2">{{$paymentRequest->method->name}}</td>
                                <td class="py-2">{{$paymentRequest->amount_paid}}</td>
                                <td class="py-2">{{$paymentRequest->amount_to_pay}}</td>
                                <td class="py-2">
                                    <a href="{{asset('img/users/students/payments/' . $paymentRequest->voucher)}}"
                                       target="_blank">
                                        <img src="{{ asset('img/icons/see.png') }}" alt="edit" class="w-6">
                                    </a>
                                </td>
                                <td class="py-2">{{$paymentRequest->formattedCreatedAt}}</td>
                                <td class="py-2">
                                    @if($paymentRequest->accepted)
                                            <img src="{{asset('img/icons/accepted.png')}}" alt="check" class="w-10">
                                    @else
                                    <button type="button" onclick="handleShowModal({{$paymentRequest->id}})">
                                        <img src="{{asset('img/icons/noAccepted.png')}}" alt="check" class="w-10">
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </section>
        @endif


        <div id="modalConfirm">

        </div>
    </div>
    <script>
        const handleShowModal = (id) => {
            const modalConfirm = document.getElementById('modalConfirm');
            modalConfirm.innerHTML = `
            <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                            Aprobar pago</h3>
                                        <div class="mt-2">
                                            <p class="text-md text-gray-500">¿Desea aprobar el pago?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"
                                        class="btn btn--primary mx-2" onclick="approvePayment(${id})">
                                    Aprobar
                                </button>
                                <button type="button" onclick="handleCloseModal()"
                                        class="btn btn--secondary mx-2">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        const handleCloseModal = () => {
            const modalConfirm = document.getElementById('modalConfirm');
            modalConfirm.innerHTML = '';
        }

        const approvePayment = (id) => {
            console.log(id);

            fetch('/admin/estudiantes/mis-pagos/aprobar-pago', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id
                })
            }).then(response => response.json())
                .then(data => {
                    console.log(data);
                    handleCloseModal();
                    window.location.reload();
                })
                .catch(error => console.error(error));
        }
    </script>
@endsection
