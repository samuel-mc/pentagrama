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
    <form action="/admin/personal/agregar" method="POST" id="formAddPersonal">
        @csrf
        <div class="grid grid-cols-3">
            <div class="flex items-center justify-end col-start-3">
                <span class="text-lg roboto-regular mr-3">Activo</span>
                <label class="switch">
                    <input type="checkbox" disabled checked>
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <h2 class="text-2xl not-serif-regular text-dark_pink mb-4">Información personal</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <input type="text" placeholder="Nombre" name="nombre" class="input">
            <input type="text" placeholder="Apellido" name="apellido" class="input">
            <input type="phone" placeholder="Teléfono" name="telefono" class="input">
            <input type="text" placeholder="Dirección" name="direccion" class="input">
            <input type="number" placeholder="Salario" name="salario" class="input">
            <div>
                <select name="rol" id="rol" class="input w-full">
                    <option value="">Selecciona un rol</option>
                    @foreach($types as $role)
                        <option value="{{ $role->id }}" data-needs-login="{{ $role->need_login }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="loginData" class="hidden">
            <h2 class="text-2xl not-serif-regular text-dark_pink my-4">Login</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
                <input type="need_login" hidden name="need_login" id="needLogin">
                <input type="text" placeholder="Username" name="username" class="input">
                <input type="password" placeholder="Contraseña" name="contrasena" class="input">
            </div>
        </div>
        <div class="text-end my-10">
            <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Cancelar</button>
            <button class="roboto-bold btn btn--primary" type="submit">Guardar</button>
        </div>
    </form>
</div>

<script>
    const formAddPersonal = document.getElementById("formAddPersonal");

    formAddPersonal.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(formAddPersonal);
        const errors = [];
        if (formData.get("nombre") === "") {
            errors.push("El nombre es requerido.");
        }

        if (formData.get("apellido") === "") {
            errors.push("El apellido es requerido.");
        }

        if (formData.get("telefono") === "") {
            errors.push("El teléfono es requerido.");
        }

        if (formData.get("direccion") === "") {
            errors.push("La dirección es requerida.");
        }

        if (formData.get("salario") === "") {
            errors.push("El salario es requerido.");
        }

        if (formData.get("rol") === "") {
            errors.push("El rol es requerido.");
        }

        if (formData.get("need_login") === "1") {
            if (formData.get("username") === "") {
                errors.push("El username es requerido.");
            }

            if (formData.get("contrasena") === "") {
                errors.push("La contraseña es requerida.");
            }
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
        window.location.href = "/admin/info-adicional/como-nos-encontraste";
    };

    const rol = document.getElementById("rol");
    rol.addEventListener("change", function() {
        const needsLogin = this.options[this.selectedIndex].getAttribute("data-needs-login");
        const needLogin = document.getElementById("needLogin");
        console.log(needsLogin);
        if (needsLogin === "1") {
            document.getElementById("loginData").style.display = "block";
            needLogin.value = "1";
        } else {
            document.getElementById("loginData").style.display = "none";
            needLogin.value = "0";
        }
        return;
    });
</script>

@endsection
