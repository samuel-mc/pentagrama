@extends('academia.layout.app')

@section('content')
    <div>
        <div id="errors">
        </div>
        <form action="{{route('admin.estudiantes.pagos.agregar')}}" method="post" id="formPaymentStudent" enctype="multipart/form-data">
            @csrf
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                <input type="text" name="student_id" value="{{$student->id}}" hidden>
                <input type="text" id="montoAPagar" name="amount_to_pay" hidden>
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Estudiante</h3>
                    <input type="text" placeholder="Estudiante" name="nombreEstudiante" class="input h-fit" disabled id="fechaPagpStudent" value="{{$student->name}} {{$student->last_name}}">
                </div>
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Tipo de pago</h3>
                    <select name="payment_type_id" class="input w-full" onchange="handleTipoPago()" id="selectPaymentType">
                        <option value="">Tipo de pago</option>
                        @foreach($paymentTypes as $paymentType)
                            <option value="{{ $paymentType->id }}" value-name="{{ $paymentType->name }}">{{ $paymentType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mx-4 my-2 hidden" id="divGrupo">
                    <h3 class="text-sm mb-1 text-light_pink">Grupo</h3>
                    <select name="group_id" id="grupoAPagar" class="input w-full" onchange="handleChangeGroup()">
                        <option value="">Seleccionar un grupo</option>
                        @foreach ($courseByStudent as $course)
                            <option value="{{$course->id}}" monto-mensual="{{$course->monthly_payment}}" fecha-pago="{{$course->monthly_payment_date}}">{{$course->course->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mx-4 my-2 hidden" id="divFechaPago">
                    <h3 class="text-sm mb-1 text-light_pink">Fecha de pago</h3>
                    <input type="text" placeholder="Fecha de pago" name="fechaPagoStudent" class="input h-fit" disabled id="fechaPagoStudent" value="{{$student->formattedPaymentDate}}">
                </div>
                <div class="mx-4 my-2 hidden" id="divMontoMensual">
                    <h3 class="text-sm mb-1 text-light_pink">Monto mensual</h3>
                    <input type="text" placeholder="Monto mensual" name="montoMensualStudent" class="input h-fit" disabled id="montoMensualStudent" value="{{$student->paymentsData->monthly_payment}}">
                </div>
                <div class="mx-4 my-2 hidden" id="divInscripcion">
                    <h3 class="text-sm mb-1 text-light_pink">Inscripción</h3>
                    <input type="text" placeholder="Inscripción" name="montoInscripcionStudent" class="input h-fit" disabled id="montoInscripcionStudent" value="{{$student->paymentsData->inscription_payment}}">
                </div>
            </section>
            <section class="my-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Método de pago</h3>
                    <select name="payment_method_id" class="input w-full">
                        <option value="">Método de pago</option>
                        @foreach($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Monto que paga</h3>
                    <input type="number" placeholder="Monto que paga" name="amount_paid"  step="0.1" id="montoPagado" class="input w-full" onkeyup="handleMontoRestante()">
                </div>
                <div class="mx-2 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Tasa en bs</h3>
                    <input type="number" step="0.1" placeholder="Tasa en bs" name="rate" class="input">
                </div>
                <div class="mx-2 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Referencia</h3>
                    <input type="text" placeholder="Referencia" name="reference" class="input">
                </div>
            </section>
            <section class="my-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Foto del capture</h3>
                    <input type="file" class="input w-full" id="voucher" name="voucher">
                </div>
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Fecha del capture</h3>
                    <input type="date" name="voucher_date" class="input w-full">
                </div>
            </section>
            <section class="my-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 items-end">
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Monto restante</h3>
                    <input type="text" placeholder="Monto restante" name="montoRestante" class="input w-full" readonly id="montoRestante" value="0">
                </div>
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Pagar antes del</h3>
                    <input type="date" name="due_date" class="input w-full">
                </div>
            </section>
            <section class="text-end my-10">
                <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Cancelar</button>
                <button class="roboto-bold btn btn--primary" type="submit">Guardar</button>
            </section>
        </form>

    </div>
    <script>
        const handleTipoPago = () => {
            const selectPaymentType = document.getElementById("selectPaymentType");
            const selectedPaymentType = selectPaymentType.options[selectPaymentType.selectedIndex].getAttribute("value-name");

            console.log(selectedPaymentType);

            const divGrupo = document.getElementById("divGrupo");
            const divMontoMensual = document.getElementById("divMontoMensual");
            const divInscripcion = document.getElementById("divInscripcion");
            const divFechaPago = document.getElementById("divFechaPago");

            const montoAPagar = document.getElementById("montoAPagar");
            const montoPagado = document.getElementById("montoPagado");
            const montoRestante = document.getElementById("montoRestante");
            const fechaPagoStudent = document.getElementById("fechaPagoStudent");
            const grupoAPagar = document.getElementById("grupoAPagar");

            montoPagado.value = 0;
            montoRestante.value = 0;
            fechaPagoStudent.value = "";
            grupoAPagar.value = "";

            if (!selectedPaymentType) {
                divGrupo.classList.add("hidden");
                divMontoMensual.classList.add("hidden");
                divInscripcion.classList.add("hidden");
                divFechaPago.classList.add("hidden");

                montoAPagar.value = "";
                return;
            }

            if (selectedPaymentType === 'Inscripción') {
                divGrupo.classList.add("hidden");
                divMontoMensual.classList.add("hidden");
                divInscripcion.classList.remove("hidden");
                divFechaPago.classList.add("hidden");
                montoAPagar.value = document.getElementById("montoInscripcionStudent").value;
            }

            if (selectedPaymentType === 'Mensualidad') {
                divGrupo.classList.remove("hidden");
                divMontoMensual.classList.remove("hidden");
                divInscripcion.classList.add("hidden");
                divFechaPago.classList.remove("hidden");
                montoAPagar.value = "";
            }

            if (selectedPaymentType === 'Otro') {
                divGrupo.classList.add("hidden");
                divMontoMensual.classList.add("hidden");
                divInscripcion.classList.add("hidden");
                divFechaPago.classList.add("hidden");
                montoAPagar.value = "";
            }


        }

        const handleMontoRestante = () => {
            let montoAPagar = document.getElementById("montoAPagar").value;
            let montoPagado = document.getElementById("montoPagado").value;
            let montoRestante = document.getElementById("montoRestante");

            montoRestante.value = (montoAPagar - montoPagado) > 0 ? montoAPagar - montoPagado : 0;
        }

        const formPaymentStudent = document.getElementById("formPaymentStudent");
        formPaymentStudent.addEventListener('submit', function (e) {
            e.preventDefault();

            const errors = document.getElementById("errors");
            const errorsList = [];


            if (!document.getElementsByName("payment_type_id")[0].value) {
                errorsList.push("El tipo de pago es requerido");
            }

            if (!document.getElementsByName("amount_paid")[0].value) {
                errorsList.push("El monto a pagar es requerido");
            }


            if (!document.getElementsByName("rate")[0].value) {
                errorsList.push("La tasa es requerida");
            }

            if (!document.getElementsByName("payment_method_id")[0].value) {
                errorsList.push("El método de pago es requerido");
            }

            if (!document.getElementsByName("voucher")[0].value) {
                errorsList.push("La foto del capture es requerida");
            }

            if (!document.getElementsByName("voucher_date")[0].value) {
                errorsList.push("La fecha del capture es requerida");
            }

            if (!document.getElementsByName("reference")[0].value) {
                errorsList.push("La referencia es requerida");
            }

            errors.innerHTML = "";
            if (errorsList.length > 0) {
                const errorListUl = document.createElement("ul");

                errorListUl.setAttribute("class", "list-disc list-inside w-full bg-red-100 border-2 border-red-500 rounded p-2 my-5");
                errorsList.forEach(function(error) {
                    const li = document.createElement("li");
                    li.setAttribute("class", "text-red-500");
                    li.textContent = error;
                    errorListUl.appendChild(li);
                });
                errors.appendChild(errorListUl);
                return;
            }



            // $requestStudentPayment->amount_to_pay = $request->amount_to_pay; √
            // $requestStudentPayment->amount_paid = $request->amount_paid; √
            // $requestStudentPayment->due_date = $request->due_date; √
            // $requestStudentPayment->student_id = $request->student_id; √
            // $requestStudentPayment->group_id = $request->group_id; √
            // $requestStudentPayment->rate = $request->rate; √
            // $requestStudentPayment->is_paid = $request->is_paid; // se calcula en el backend
            // $requestStudentPayment->payment_type_id = $request->payment_type_id; √
            // $requestStudentPayment->payment_method_id = $request->payment_method_id; √
            // $requestStudentPayment->voucher = $request->voucher;
            // $requestStudentPayment->voucher_date = $request->voucher_date;
            // $requestStudentPayment->reference = $request->reference;
            this.submit();
        })
    </script>
@endsection
