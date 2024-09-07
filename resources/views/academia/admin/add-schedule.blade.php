@extends("academia.layout.app")

@section("content")

    <div id="errors">
    </div>
    <form action="{{route('admin.horarios.agregar')}}" method="post" id="addScheduleForm">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-4">
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Estudiante</h3>
                <select name="student" id="student" class="input w-full" onchange="validateIfGroupExists()">
                    <option value="">Seleccione un estudiante</option>
                    @foreach($students as $student)
                        <option value="{{$student->id}}">{{$student->name}} {{$student->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Cátedra</h3>
                <select name="course" id="course" class="input w-full" onchange="handleCourseChange()">
                    <option value="">Seleccione una cátedra</option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
            </div>
            <div id="teacherDiv" class="hidden">
                <h3 class="text-sm mb-1 text-light_pink">Profesor</h3>
                <select name="teacher" id="teacher" class="input w-full" onchange="validateIfGroupExists()">
                    <option value="">Seleccione un profesor</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-6">
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Día</h3>
                <select name="day" id="day" class="input w-full">
                    <option value="">Seleccione un día</option>
                    @foreach($days as $day)
                        <option value="{{$day->id}}" {{$day->id == $selectedDay ? 'selected' : ''}}>{{$day->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Hora de inicio</h3>
                <input type="time" name="start_time" class="input w-full" placeholder="Hora de inicio" value="{{$selectedHour}}">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-6 hidden" id="paymentDiv">
            <input type="hidden" name="groupExists" value="true" id="groupExists">
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Pago mensual</h3>
                <input type="number" name="monthly_payment" class="input w-full" placeholder="Pago mensual">
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Fecha de pago</h3>
                <input type="date" name="monthly_payment_date" class="input w-full" placeholder="Fecha de inicio">
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn--primary">Agregar horario</button>
        </div>
    </form>

    <script>
        const handleCourseChange = () => {
            const courseSelect = document.getElementById('course');
            const courseId = courseSelect.value;
            if (!courseId) {
                const teacherDiv = document.getElementById('teacherDiv');
                teacherDiv.classList.add('hidden');
                const teacherSelect = document.getElementById('teacher');
                teacherSelect.innerHTML = '';
                teacherSelect.disabled = true;
            } else {
                fetch(`/admin/cursos-por-profesor/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        const teacherDiv = document.getElementById('teacherDiv');
                        teacherDiv.classList.remove('hidden');
                        const teacherSelect = document.getElementById('teacher');
                        teacherSelect.innerHTML = '';
                        teacherSelect.disabled = false;
                        teacherSelect.innerHTML = '<option value="">Seleccione un profesor</option>';
                        data.forEach(teacher => {
                            const option = document.createElement('option');
                            option.value = teacher.id;
                            option.innerText = `${teacher.name}`;
                            teacherSelect.appendChild(option);
                        });
                    });
            }

        }

        const addScheduleForm = document.getElementById('addScheduleForm');
        addScheduleForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(addScheduleForm);
            const errors = [];
            if (!formData.get('student')) {
                errors.push('El estudiante es requerido.');
            }
            if (!formData.get('course')) {
                errors.push('La cátedra es requerida.');
            }
            if (!formData.get('teacher')) {
                errors.push('El profesor es requerido.');
            }
            if (!formData.get('day')) {
                errors.push('El día es requerido.');
            }
            if (!formData.get('start_time')) {
                errors.push('La hora de inicio es requerida.');
            }
            if (!formData.get('monthly_payment') && formData.get('groupExists') === 'false') {
                errors.push('El pago mensual es requerido.');
            }
            if (!formData.get('monthly_payment_date') && formData.get('groupExists') === 'false') {
                errors.push('La fecha de pago es requerida.');
            }
            if (errors.length > 0) {
                const errorDiv = document.getElementById('errors');
                const errorList = document.createElement('ul');
                errorList.setAttribute('class', 'list-disc list-inside w-full bg-red-100 border-2 border-red-500 rounded p-2 my-5');
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.setAttribute('class', 'text-red-500');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                errorDiv.innerHTML = '';
                errorDiv.appendChild(errorList);
                return;
            }
            this.submit();
        });

        const validateIfGroupExists = () => {
            const studentId = document.getElementById('student').value ?? null;
            const courseId = document.getElementById('course').value ?? null;
            const teacherId = document.getElementById('teacher').value ?? null;
            if (studentId && courseId && teacherId) {
                fetch(`/admin/grupos/${studentId}/${teacherId}/${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                       console.log(!!data.id);
                       if (!data.id) {
                           const paymentDiv = document.getElementById('paymentDiv');
                            paymentDiv.classList.remove('hidden');
                            document.getElementById('groupExists').value = false;
                       }
                    });
            } else {
                const paymentDiv = document.getElementById('paymentDiv');
                paymentDiv.classList.add('hidden');
                document.getElementById('groupExists').value = true;
            }
        }

    </script>
@endsection
