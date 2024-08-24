@extends("academia.layout.app")

@section("content")
<div>
    <div id="errors"></div>
    <form action="/admin/estudiantes/{{$id}}/grupos/agregar" method="POST" id="formAddStudentGroup">
        @csrf
        <input type="hidden" name="student_id" value="{{$id}}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Curso</h3>
                <select name="group_id" id="group_id" class="input w-full">
                    <option value="">Selecciona un curso</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->course->name }}  - {{$group->age->name}} - {{$group->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Mensualidad</h3>
                <input type="number" placeholder="Mensualidad" name="monthly_payment" class="input  w-full">
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Fecha de pago</h3>
                <input type="date" placeholder="Fecha de pago" name="payment_date" class="input  w-full">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="button" class="btn btn--secondary m-2">Cancelar</button>
            <button type="submit" class="btn btn--primary m-2">Agregar</button>
        </div>
    </form>
</div>

<script>
    const formAddStudentGroup = document.getElementById('formAddStudentGroup');
    formAddStudentGroup.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(formAddStudentGroup);
        let errors = [];

        if (formData.get('group_id') === "") {
            errors.push('El campo curso es requerido');
        }

        if (formData.get('monthly_payment') === "") {
            errors.push('El campo mensualidad es requerido');
        }

        if (formData.get('payment_date') === "") {
            errors.push('El campo fecha de pago es requerido');
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

        this.submit();
    });
</script>

@endsection