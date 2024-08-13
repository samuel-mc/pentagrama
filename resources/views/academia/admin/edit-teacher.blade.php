@extends("academia.layout.app")

@section("content")
<div>
    <div id="errors">
    </div>
    <form action="/admin/profesores/editar/{{$teacher->id}}" method="POST" id="formAddProfesor">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <input type="text" placeholder="Nombre" name="nombre" class="input" value="{{$teacher->name}}">
            <input type="text" placeholder="Apellido" name="apellido" class="input" value="{{$teacher->last_name}}">
            <input type="text" placeholder="Cédula de identidad" name="cedula" class="input" value="{{$teacher->id_card}}">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <input type="date" placeholder="Fecha de nacimiento" name="fechaNacimiento" class="input" value="{{$teacher->formattedBirthday}}">
            <input type="text" placeholder="Dirección" name="direccion" class="input" value="{{$teacher->address}}">
            <input type="text" placeholder="Número de WhatsApp" name="numeroWhatsApp" class="input" value="{{$teacher->whatsapp_number}}">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <input type="text" placeholder="Número de teléfono en caso de emergencia" name="numeroEmergencia" class="input" value="{{$teacher->another_number}}">
        </div>
        <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-10">
            <input type="text" placeholder="Correo electrónico" name="correo" class="input" value="{{$teacher->email}}">
            <input type="password" placeholder="Contraseña" name="contrasena" class="input" value="{{$teacher->name}}">
        </div> -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-10">
            <input type="file" placeholder="Foto" class="input" accept="image/*" id="foto">
            <input type="hidden" name="foto" id="fotoB64" value="{{$teacher->photo}}">
            <div id="imgDiv">
                <img src="{{$teacher->photo}}" alt="user" class="w-20 rounded">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-10">

            <div class="flex items-center">
                <span class="text-lg roboto-regular mr-3">Activo</span>
                <label class="switch">
                    <input type="checkbox" name="active" @checked($teacher->active) >
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="text-end my-10">
            <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Cancelar</button>
            <button class="roboto-bold btn btn--primary" type="submit">Guardar</button>
        </div>
    </form>
</div>

<script>
    const uploadField = document.getElementById("foto");

    uploadField.onchange = function() {
        if (this.files[0].size > 2097152) {
            alert("La foto es muy grande. Debe ser menor a 2MB.");
            this.value = "";
        } else {
            const reader = new FileReader();
            const imgDiv = document.getElementById("imgDiv");
            imgDiv.innerHTML = "";
            const img = document.createElement("img");
            img.setAttribute("src", URL.createObjectURL(this.files[0]));
            img.setAttribute("alt", "user");
            img.setAttribute("class", "w-20 rounded");
            imgDiv.appendChild(img);
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

    const handleCancel = () => {
        window.location.href = "/admin/profesores";
    };

</script>

@endsection