@extends("academia.layout.app")

@section("content")
<div>
    <div id="errors">
        @if ($errors->any())
        <ul class="list-disc list-inside w-full bg-red-100 border-2 border-red-500 rounded p-2 my-5">
            @foreach ($errors->all() as $error)
            <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
        @endif

    </div>
    <form action="/admin/inscripcion" method="POST" id="formAddEdad">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <div class="flex items-center justify-end col-start-3">
                <span class="text-lg roboto-regular mr-3">Activo</span>
                <label class="switch">
                    <input type="checkbox" disabled checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <!-- Datos del estudiante -->
        <h2 class="text-2xl not-serif-regular text-dark_pink mb-4">Estudiante</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <input type="text" placeholder="Nombre" name="nombre" class="input">
            <input type="text" placeholder="Apellidos" name="apellidos" class="input">
            <input type="date" placeholder="Fecha de nacimiento" name="fecha_nacimiento" class="input">
            <div>
                <select name="genero" id="genero" class="input w-full">
                    <option value="" class="text-gray-400">Género</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <!-- TODO: Preguntar por catedra a cursar -->
            <div>
                <select name="modalidad" id="modalidad" class="input w-full">
                    <option value="">Modalidad</option>
                    <option value="Regular">Regular</option>
                    <option value="Becado">Becado</option>
                    <option value="Intercambio">Intercambio</option>
                </select>
            </div>
        </div>

        <!-- Datos del representante -->
        <h2 class="text-2xl not-serif-regular text-dark_pink my-4">Representante</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <div>
                <select name="como_nos_encontraste" id="como_nos_encontraste" class="input w-full">
                    <option value="">¿Cómo conoció el programa?</option>
                    @foreach($howFoundUs as $how)
                    <option value="{{ $how->id }}">{{ $how->how }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" placeholder="Nombre" name="nombre_representante" class="input">
            <input type="text" placeholder="Apellidos" name="apellidos_representante" class="input">
            <input type="text" placeholder="Cédula de identidad" name="cedula_representante" class="input">
            <input type="phone" placeholder="Número de whatsapp" name="whatsapp_representante" class="input">
            <input type="phome" placeholder="Número de teléfono en caso de emergencia" name="telefono_emergencia_representante" class="input">
            <input type="text" placeholder="Ocupación" name="ocupacion_representante" class="input">
            <input type="text" placeholder="Dirección" name="direccion_representante" class="input">
        </div>

        <!-- Datos del pago -->
        <h2 class="text-2xl not-serif-regular text-dark_pink my-4">Pago</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <div>
                <select name="metodo_pago" id="metodo_pago" class="input w-full">
                    <option value="">Método de pago</option>
                    <option value="Pago móvil">Pago móvil</option>
                    <option value="Efectivo">Efectivo</option>
                </select>
            </div>
            <input type="number" placeholder="Monto mensual" name="monto" class="input">
            <input type="number" placeholder="Inscripción" name="inscripcion" class="input">
            <input type="date" placeholder="Fecha de pago mensual" name="fechaPago" class="input">
        </div>

        <!-- Datos de login -->
        <h2 class="text-2xl not-serif-regular text-dark_pink my-4">Login</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <input type="email" placeholder="Correo electrónico" name="correo" class="input">
            <input type="password" placeholder="Contraseña" name="contrasena" class="input">
        </div>

        <div class="text-end my-10">
            <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Cancelar</button>
            <button class="roboto-bold btn btn--primary" type="submit">Guardar</button>
        </div>
    </form>
</div>

<script>
    const formAddEdad = document.getElementById("formAddEdad");

    formAddEdad.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(formAddEdad);
        const errors = [];
        if (formData.get("nombre") === "") {
            errors.push("El nombre es requerido.");
        }

        if (formData.get("apellidos") === "") {
            errors.push("Los apellidos son requeridos.");
        }

        if (formData.get("fecha_nacimiento") === "") {
            errors.push("La fecha de nacimiento es requerida.");
        }

        if (formData.get("genero") === "") {
            errors.push("El género es requerido.");
        }

        if (formData.get("modalidad") === "") {
            errors.push("La modalidad es requerida.");
        }

        if (formData.get("como_nos_encontraste") === "") {
            errors.push("Cómo nos encontraste es requerido.");
        }

        if (formData.get("nombre_representante") === "") {
            errors.push("El nombre del representante es requerido.");
        }

        if (formData.get("apellidos_representante") === "") {
            errors.push("Los apellidos del representante son requeridos.");
        }

        if (formData.get("cedula_representante") === "") {
            errors.push("La cédula del representante es requerida.");
        }

        if (formData.get("whatsapp_representante") === "") {
            errors.push("El número de whatsapp del representante es requerido.");
        }

        if (formData.get("telefono_emergencia_representante") === "") {
            errors.push("El número de teléfono de emergencia del representante es requerido.");
        }

        if (formData.get("ocupacion_representante") === "") {
            errors.push("La ocupación del representante es requerida.");
        }

        if (formData.get("direccion_representante") === "") {
            errors.push("La dirección del representante es requerida.");
        }

        if (formData.get("metodo_pago") === "") {
            errors.push("El método de pago es requerido.");
        }

        if (formData.get("monto") === "") {
            errors.push("El monto es requerido.");
        }

        if (formData.get("inscripcion") === "") {
            errors.push("La inscripción es requerida.");
        }

        if (formData.get("fechaPago") === "") {
            errors.push("La fecha de pago es requerida.");
        }

        if (formData.get("correo") === "") {
            errors.push("El correo electrónico es requerido.");
        }

        if (formData.get("contrasena") === "") {
            errors.push("La contraseña es requerida.");
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

    const handleCancel = () => {
        window.location.href = "{{ url()->previous() }}";
    };
</script>

@endsection