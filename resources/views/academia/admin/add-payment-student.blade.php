@extends("academia.layout.app")

@section("content")
<div>
    <div id="errors">
    </div>
    <form action="/admin/estudiantes/{{$student->id}}/pagos/agregar" method="post" id="formPaymentStudent" enctype="multipart/form-data">
        @csrf
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            <input type="text" name="student_id" value="{{$student->id}}" hidden>
            <input type="text" id="montoAPagar" name="montoAPagar" hidden>
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Estudiante</h3>
                <input type="text" placeholder="Estudiante" name="nombreEstudiante" class="input h-fit" disabled id="fechaPagpStudent" value="{{$student->name}} {{$student->last_name}}">
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Tipo de pago</h3>
                <select name="payment_type" class="input w-full" onchange="handleTipoPago()" id="selectPaymentType">
                    <option value="">Tipo de pago</option>
                    @foreach($paymentTypes as $paymentType)
                    <option value="{{ $paymentType->id }}" value-name="{{ $paymentType->name }}">{{ $paymentType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mx-4 my-2 hidden" id="divGrupo">
                <h3 class="text-sm mb-1 text-light_pink">Grupo</h3>
                <select name="grupoAPagar" id="grupoAPagar" class="input w-full" onchange="handleChangeGroup()">
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
                <select name="payment_method" class="input w-full">
                    <option value="">Método de pago</option>
                    @foreach($paymentMethods as $paymentMethod)
                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Monto que paga</h3>
                <input type="number" placeholder="Monto que paga" name="montoPagado" id="montoPagado" class="input w-full" onkeyup="handleMontoRestante()">
            </div>
            <div class="mx-2 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Tasa en bs</h3>
                <input type="number" placeholder="Tasa en bs" name="tasa" class="input">
            </div>
            <div class="mx-2 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Referencia</h3>
                <input type="text" placeholder="Referencia" name="referencia" class="input">
            </div>
        </section>
        <section class="my-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Foto del capture</h3>
                <input type="file" class="input w-full" id="voucher" name="capture_photo">
{{--                <input type="text" name="capture_photo" hidden id="capturePhoto">--}}
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Fecha del capture</h3>
                <input type="date" name="capture_date" class="input w-full">
            </div>
        </section>
        <section class="my-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 items-end">
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Monto restante</h3>
                <input type="text" placeholder="Monto restante" name="montoRestante" class="input w-full" readonly id="montoRestante" value="0">
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm mb-1 text-light_pink">Pagar antes del</h3>
                <input type="date" name="pay_before" class="input w-full">
            </div>
        </section>
        <section class="text-end my-10">
            <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Cancelar</button>
            <button class="roboto-bold btn btn--primary" type="submit">Guardar</button>
        </section>
    </form>

</div>

<script>
    const handleCancel = () => {
        window.location.href = "/admin/estudiantes/{{$student->id}}/pagos";
    }

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
        let montoPagado = document.getElementsByName("montoPagado")[0].value;
        let montoRestante = document.getElementById("montoRestante");

        montoRestante.value = (montoAPagar - montoPagado) > 0 ? montoAPagar - montoPagado : 0;
    }

    const handleChangeGroup = () =>{
        const grupoAPagar = document.getElementById("grupoAPagar");
        const montoMensualStudent = document.getElementById("montoMensualStudent");
        const fechaPagoStudent = document.getElementById("fechaPagoStudent");

        const montoAPagar = document.getElementById("montoAPagar");
        const montoPagado = document.getElementById("montoPagado");

        const montoMensual = grupoAPagar.options[grupoAPagar.selectedIndex].getAttribute("monto-mensual");
        const fechaPago = grupoAPagar.options[grupoAPagar.selectedIndex].getAttribute("fecha-pago");

        montoMensualStudent.value = montoMensual;
        fechaPagoStudent.value = fechaPago;
        montoAPagar.value = montoMensual;
        montoPagado.value = 0;

    }

    const formPaymentStudent = document.getElementById("formPaymentStudent");

    formPaymentStudent.addEventListener("submit", function(event) {
        console.log("submit");
        event.preventDefault();

        const formData = new FormData(formPaymentStudent);
        const errors = [];


        if (formData.get("payment_type") === "") {
            errors.push("El tipo de pago es requrido.");
        }

        if (formData.get("payment_method") === "") {
            errors.push("El método de pago es requerido.");
        }

        if (formData.get("montoPagado") === "") {
            errors.push("El monto pagado es requerido.");
        }

        if (formData.get("tasa") === "") {
            errors.push("La tasa es requerida.");
        }

        if (formData.get("capture_photo") === "") {
            errors.push("El capture es requerido.");
        }

        if (formData.get("capture_date") === "") {
            errors.push("La fecha del capture es requerida.");
        }

        const montoRestante = document.getElementById("montoRestante").value;
        if (formData.get("pay_before") === "" && montoRestante > 0) {
            errors.push("La fecha de pago es requerida.");
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
        }
    };
</script>

@endsection
