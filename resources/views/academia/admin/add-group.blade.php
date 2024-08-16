@extends('academia.layout.app')

@section('content')
<div>
    <div id="errors">
    </div>
    <form action="/admin/grupos/agregar" method="post" id="groupForm">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
            <input type="text" placeholder="Nombre" name="name" class="input">
            <select name="teacher" class="input">
                <option value="">Selecciona un profesor</option>
                @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }} {{$teacher->last_name}}</option>
                @endforeach
            </select>
            <select name="course" class="input">
                <option value="">Selecciona una cátedra</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            <select name="age" class="input">
                <option value="">Selecciona una edad</option>
                @foreach($ages as $age)
                <option value="{{ $age->id }}">{{ $age->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="my-5">
            <h2 class="text-2xl text-purple_p not-serif-regular">Horario</h2>
            <input type="number" name="schedules" value="1" id="shedules" hidden>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
                <div class="flex items-end">
                    <select name="day_schedule1" class="input w-full" id="day_schedule1">
                        <option value="">Selecciona un día</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miércoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sábado</option>
                    </select>
                </div>
                <div>
                    <h3 class="text-sm mb-1 text-light_pink">Hora de inicio</h3>
                    <input type="time" name="start_time_schedule1" class="input w-full" placeholder="Hora de inicio" id="start_time_schedule1">
                </div>
                <div>
                    <h3 class="text-sm mb-1 text-light_pink">Hora de inicio</h3>
                    <input type="time" name="end_time_schedule1" class="input w-full" placeholder="Hora de fin" id="end_time_schedule1">
                </div>
            </div>
            <div id="anotherSchedules"></div>
            <div class="flex justify-end py-5 px-2">
                <button class="btn btn--secondary" type="button" onclick="handleAddSchedule()">
                    Agregar horario
                </button>
            </div>
        </div>
        <div class="text-end my-10">
            <button class="roboto-bold btn btn--secondary" type="button" onclick="handleCancel()">Cancelar</button>
            <button class="roboto-bold btn btn--primary" type="submit">Guardar</button>
        </div>
    </form>
</div>
<script>
    const handleCancel = () => {
        window.location.href = "/admin/profesores";
    };


    const groupForm = document.getElementById("groupForm");

    groupForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(groupForm);
        const errors = [];
        if (formData.get("name") === "") {
            errors.push("El nombre es requerido.");
        }
        if (formData.get("teacher") === "") {
            errors.push("El profesor es requerido.");
        }
        if (formData.get("course") === "") {
            errors.push("La cátedra es requerida.");
        }
        if (formData.get("age") === "") {
            errors.push("La edad es requerida.");
        }
        if (formData.get("schedules") === "0") {
            errors.push("Debes agregar al menos un horario.");
        }
        const schedules = parseInt(formData.get("schedules"));
        for (let i = 0; i <= schedules; i++) {
            const day = formData.get(`day_schedule${i}`);
            const startTime = formData.get(`start_time_schedule${i}`);
            const endTime = formData.get(`end_time_schedule${i}`);
            if (day === "") {
                errors.push(`Debes seleccionar un día para el horario ${i + 1}.`);
            }
            if (startTime === "") {
                errors.push(`Debes seleccionar una hora de inicio para el horario ${i + 1}.`);
            }
            if (endTime === "") {
                errors.push(`Debes seleccionar una hora de fin para el horario ${i + 1}.`);
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

    const handleAddSchedule = () => {
        const schedules = document.getElementById("shedules");
        schedules.value = parseInt(schedules.value) + 1;
        const schedulesCount = parseInt(schedules.value);

        const externalContainer = document.createElement("div");
        externalContainer.setAttribute("class", "grid grid-cols-1 md:grid-cols-3 gap-6 my-2");
        const selectDayContainer = document.createElement("div");
        selectDayContainer.setAttribute("class", "flex items-end");
        const selectDay = document.createElement("select");
        selectDay.setAttribute("name", `day_schedule${schedulesCount}`);
        selectDay.setAttribute("class", "input w-full");
        selectDay.setAttribute("id", `day_schedule${schedulesCount}`);

        const selectDayOptions = [
            { value: "", text: "Selecciona un día" },
            { value: "1", text: "Lunes" },
            { value: "2", text: "Martes" },
            { value: "3", text: "Miércoles" },
            { value: "4", text: "Jueves" },
            { value: "5", text: "Viernes" },
            { value: "6", text: "Sábado" }
        ];

        selectDayOptions.forEach(function(option) {
            const optionElement = document.createElement("option");
            optionElement.setAttribute("value", option.value);
            optionElement.textContent = option.text;
            selectDay.appendChild(optionElement);
        });

        selectDayContainer.appendChild(selectDay);
        externalContainer.appendChild(selectDayContainer);

        const startTimeContainer = document.createElement("div");
        const startTimeLabel = document.createElement("h3");
        startTimeLabel.setAttribute("class", "text-sm mb-1 text-light_pink");
        startTimeLabel.textContent = "Hora de inicio";
        const startTimeInput = document.createElement("input");
        startTimeInput.setAttribute("type", "time");
        startTimeInput.setAttribute("name", `start_time_schedule${schedulesCount}`);
        startTimeInput.setAttribute("class", "input w-full");
        startTimeInput.setAttribute("placeholder", "Hora de inicio");
        startTimeInput.setAttribute("id", `start_time_schedule${schedulesCount}`);
        startTimeContainer.appendChild(startTimeLabel);
        startTimeContainer.appendChild(startTimeInput);
        externalContainer.appendChild(startTimeContainer);

        const endTimeContainer = document.createElement("div");
        const endTimeLabel = document.createElement("h3");
        endTimeLabel.setAttribute("class", "text-sm mb-1 text-light_pink");
        endTimeLabel.textContent = "Hora de fin";
        const endTimeInput = document.createElement("input");
        endTimeInput.setAttribute("type", "time");
        endTimeInput.setAttribute("name", `end_time_schedule${schedulesCount}`);
        endTimeInput.setAttribute("class", "input w-full");
        endTimeInput.setAttribute("placeholder", "Hora de fin");
        endTimeInput.setAttribute("id", `end_time_schedule${schedulesCount}`);
        endTimeContainer.appendChild(endTimeLabel);
        endTimeContainer.appendChild(endTimeInput);
        externalContainer.appendChild(endTimeContainer);

        const anotherScheduleContainer = document.getElementById("anotherSchedules");
        anotherScheduleContainer.appendChild(externalContainer);


    }
</script>
@endsection