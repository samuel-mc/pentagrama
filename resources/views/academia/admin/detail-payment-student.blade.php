@extends("academia.layout.app")

@section("content")
<div>
    <div id="errors">
    </div>
    <section class="flex flex-wrap my-4">
        <input type="text" name="student_id" value="{{$student->id}}" hidden>
        <div class="mx-4 my-2">
            <h3 class="text-sm mb-1 text-light_pink">Estudiante</h3>
            <input type="text" class="input h-fit" disabled value="{{$student->name}} {{$student->last_name}}">
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm mb-1 text-light_pink">Monto mensual</h3>
            <input type="text" class="input h-fit" disabled value="{{$payment->amount}} $">
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm mb-1 text-light_pink">Inscripción</h3>
            <input type="text" class="input h-fit" disabled value="{{$student->paymentsData->inscription_payment}} $">
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm mb-1 text-light_pink">Tipo de pago</h3>
            <input type="text" class="input h-fit" disabled value="{{$payment->studentPaymentType->name}}">
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm mb-1 text-light_pink">Monto pagado</h3>
            <input type="text" class="input h-fit" disabled value="{{$payment->amountPaid}} $">
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm mb-1 text-light_pink">Tasa en bs</h3>
            <input type="text" class="input h-fit" disabled value="{{$payment->rate}}">
        </div>
    </section>
    <section class="py-6">
        @if(!$payment->is_paid)
        <div class="rounded border border-red-500 p-4 col-span-2">
            <h3 class="text-lg text-red-500 roboto-regular text-center">El pago no está completo</h3>
            <div class="flex flex-wrap items-end">
                @csrf
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Monto restante</h3>
                    <input type="text" class="input h-fit" disabled value="{{$payment->amountDue}}" id="montoRestante" name="montoRestante">
                    <input type="hidden" id="montoRestanteInicial" value="{{$payment->amountDue}}">

                </div>
                <div class="mx-4 my-2">
                    <h3 class="text-sm mb-1 text-light_pink">Pagar antes del</h3>
                    <input type="text" class="input h-fit" disabled value="{{$payment->dueDate}}">
                </div>
                <div class="mx-4 my-2">
                    <button type="button" class="btn btn--primary" onclick="handleShowCompletarPago(true)">Completar pago</button>
                </div>
            </div>
            <form action="/admin/estudiantes/{{$student->id}}/pagos/agregar" method="post" id="formPaymentStudent" class="hidden">
                @csrf
                <div>
                    <input type="text" name="student_payment_donte_id" value="{{$payment->id}}" hidden>
                    <input type="text" name="student_id" value="{{$student->id}}" hidden>
                    <section class="my-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <h3 class="text-sm mb-1 text-light_pink">Método de pago</h3>
                            <select name="payment_method" class="input w-full">
                                <option value="">Seleccionar una opción</option>
                                @foreach($paymentMethods as $paymentMethod)
                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <h3 class="text-sm mb-1 text-light_pink">Monto que paga</h3>
                            <input type="number" placeholder="Monto que paga" name="montoPagado" id="montoPagado" class="input w-full" onchange="handleMontoRestante()" max=""{{$payment->amountDue}}">
                        </div>
                        <div>
                            <h3 class="text-sm mb-1 text-light_pink">Referencia</h3>
                            <input type="text" placeholder="Referencia" name="referencia" class="input w-full">
                        </div>
                        <div>
                            <h3 class="text-sm mb-1 text-light_pink">Foto del capture</h3>
                            <input type="file" class="input w-full" id="voucher">
                            <input type="text" name="capture_photo" hidden id="capturePhoto">
                        </div>
                        <div>
                            <h3 class="text-sm mb-1 text-light_pink">Fecha del capture</h3>
                            <input type="date" name="capture_date" class="input w-full">
                        </div>
                    </section>
                    <section class="flex justify-end">
                        <button type="button" class="btn btn--secondary" onclick="handleShowCompletarPago(false)">Cancelar</button>
                        <button type="submit" class="btn btn--primary">Guardar</button>
                    </section>
                </div>
            </form>
        </div>
        @endif
    </section>
    @if(count($payment->studentPaymentDoneItems) > 0)
    <section>
        <header>
            <h2 class="text-2xl text-light_pink roboto-bold text-center my-4">Desglose de pagos</h2>
        </header>
        <main class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($payment->studentPaymentDoneItems as $item)
            <div class="grid grid-cols-1 md:grid-cols-2 border-2 rounded p-4">
                <div>
                    <div class="mx-4 my-2">
                        <h3 class="text-sm mb-1 text-light_pink">Fecha de pago</h3>
                        <input type="text" class="input h-fit w-full" disabled value="{{$item->formattedCreatedAt}}">
                    </div>
                    <div class="mx-4 my-2">
                        <h3 class="text-sm mb-1 text-light_pink">Método de pago</h3>
                        <input type="text" class="input h-fit w-full" disabled value="{{$item->studentPaymentMethods->name}}">
                    </div>
                    <div class="mx-4 my-2">
                        <h3 class="text-sm mb-1 text-light_pink">Monto pagado</h3>
                        <input type="text" class="input h-fit w-full" disabled value="{{$item->amount_paid}}">
                    </div>
                    <div class="mx-4 my-2">
                        <h3 class="text-sm mb-1 text-light_pink">Referencia</h3>
                        <input type="text" class="input h-fit w-full" disabled value="{{$item->reference}}">
                    </div>
                    <div class="mx-4 my-2">
                        <h3 class="text-sm mb-1 text-light_pink">Fecha del capture</h3>
                        <input type="text" class="input h-fit w-full" disabled value="{{$item->formattedVoucherDate}}">
                    </div>
                </div>
                <div>
                    <div class="mx-4 my-2">
                        <!-- imgbase64 -->
                        <h3 class="text-sm mb-1 text-light_pink">Foto del capture</h3>
                        <img src="{{'/img/users/students/payments/' . $item->voucher}}" alt="capture" class="w-full">
                    </div>
                </div>
            </div>
            @endforeach
        </main>
    </section>
    @endif

    <section class="text-end my-10">
        <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Regresar</button>
    </section>
    </form>

</div>

<script>
    const handleCancel = () => {
        window.location.href = "/admin/estudiantes/{{$student->id}}/pagos";
    }

    const formPaymentStudent = document.getElementById("formPaymentStudent");

    formPaymentStudent.addEventListener("submit", function(event) {
        console.log("submit");
        event.preventDefault();

        const formData = new FormData(formPaymentStudent);
        const errors = [];

        if (formData.get("payment_method") === "") {
            errors.push("El método de pago es requerido.");
        }

        if (formData.get("montoPagado") === "") {
            errors.push("El monto pagado es requerido.");
        }


        if (formData.get("capture_photo") === "") {
            errors.push("El capture es requerido.");
        }

        if (formData.get("capture_date") === "") {
            errors.push("La fecha del capture es requerida.");
        }

        if (errors.length > 0) {
            const errorDiv = document.getElementById("errors");
            const errorList = document.createElement("ul");
            errorList.setAttribute("class", "list-disc list-inside w-full bg-red-100 border-2 border-red-500 rounded p-2 my-5");
            errors.forEach(function(error) {
                const li = document.createElement("li");
                li.setAttribute("class", "text-red-500");
                li.textContent = error;
                errorList.appendChild(li);
            });
            errorDiv.innerHTML = "";
            errorDiv.appendChild(errorList);
            return;
        }

        console.log(formData);
        this.submit();

    });

    const uploadField = document.getElementById("voucher");

    uploadField.onchange = function() {
        if (this.files[0].size > 2097152) {
            alert("La foto es muy grande. Debe ser menor a 2MB.");
            this.value = "";
        } else {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById("capturePhoto").value = reader.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    };

    const handleShowCompletarPago = (show) => {
        if (show) {
            document.getElementById("formPaymentStudent").style.display = "block";
        } else {
            document.getElementById("formPaymentStudent").style.display = "none";
        }
    }

    const handleMontoRestante = () => {
        const montoRestante = document.getElementById("montoRestante")
        const montoRestanteInicial = document.getElementById("montoRestanteInicial").value;
        const montoPagado = document.getElementById("montoPagado").value;
        montoRestante.value = montoRestanteInicial - montoPagado;
    }

</script>

@endsection
