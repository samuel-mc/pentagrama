@extends("academia.layout.app")

@section("content")
<div>
    <div id="errors">
    </div>
    <form action="/admin/profesores/agregar" method="POST" id="formAddProfesor">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <input type="text" placeholder="Nombre" name="nombre" class="input">
            <input type="text" placeholder="Apellido" name="apellido" class="input">
            <input type="text" placeholder="Cédula de identidad" name="cedula" class="input">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <input type="date" placeholder="Fecha de nacimiento" name="fechaNacimiento" class="input">
            <input type="text" placeholder="Dirección" name="direccion" class="input">
            <input type="text" placeholder="Número de WhatsApp" name="numeroWhatsApp" class="input">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <input type="text" placeholder="Número de teléfono en caso de emergencia" name="numeroEmergencia" class="input">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-10">
            <input type="text" placeholder="Correo electrónico" name="correo" class="input">
            <input type="password" placeholder="Contraseña" name="contrasena" class="input">
            <input type="file" placeholder="Foto" class="input" accept="image/*" id="foto">
            <input type="hidden" name="foto" id="fotoB64">
        </div>
        <div class="text-end my-10">
            <button class="btn btn--secondary" type="button">Cancelar</button>
            <button class="btn btn--primary" type="submit">Guardar</button>
        </div>
    </form>
</div>

<script>
    const uploadField = document.getElementById("foto");

    uploadField.onchange = function() {
        if(this.files[0].size > 2097152) {
            alert("La foto es muy grande. Debe ser menor a 2MB.");
        this.value = "";
        } else {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById("fotoB64").value = reader.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    };

    const formAddProfesor = document.getElementById("formAddProfesor");
    
    formAddProfesor.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(formAddProfesor);
        const errors = [];
        if (formData.get("nombre") === "") {
            errors.push("El nombre es requerido.");
        }
        if (formData.get("apellido") === "") {
            errors.push("El apellido es requerido.");
        }
        if (formData.get("cedula") === "") {
            errors.push("La cédula de identidad es requerida.");
        }
        if (formData.get("fechaNacimiento") === "") {
            errors.push("La fecha de nacimiento es requerida.");
        }
        if (formData.get("direccion") === "") {
            errors.push("La dirección es requerida.");
        }
        if (formData.get("numeroWhatsApp") === "") {
            errors.push("El número de WhatsApp es requerido.");
        }
        if (formData.get("numeroEmergencia") === "") {
            errors.push("El número de teléfono en caso de emergencia es requerido.");
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

</script>

@endsection