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
    <form action="/admin/info-adicional/edades/agregar" method="POST" id="formAddEdad">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <input type="text" placeholder="Nombre" name="nombre" class="input">
            <input type="number" placeholder="Edad mínima" name="edad_minima" class="input" step="1">
            <input type="number" placeholder="Edad máxima" name="edad_maxima" class="input" step="1">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <input type="text" placeholder="Descripción" name="descripcion" class="input">
            <div class="flex items-center">
                <span class="text-lg roboto-regular mr-3">Activo</span>
                <label class="switch">
                    <input type="checkbox" disabled checked>
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
    const formAddEdad = document.getElementById("formAddEdad");

    formAddEdad.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(formAddEdad);
        const errors = [];
        if (formData.get("nombre") === "") {
            errors.push("El nombre es requerido.");
        }
        if (formData.get("descripcion") === "") {
            errors.push("La descripción es requerida.");
        }
        if (formData.get("edad_minima") === "") {
            errors.push("La edad mínima es requerida.");
        }
        if (formData.get("edad_maxima") === "") {
            errors.push("La edad máxima es requerida.");
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