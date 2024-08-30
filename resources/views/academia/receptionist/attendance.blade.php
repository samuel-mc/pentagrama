@extends("academia.layout.app")

@section("content")
    <div>
        <header class="grid grid-cols-2 gap-4">
            <button class="btn btn--primary" onclick="handleShowMain('students')">Estudiantes <span
                    id="attendenceStudents">{{$attendenceStudents}}</span>
            </button>
            <button class="btn btn--primary" onclick="handleShowMain('teachers')">Profesores
                <span id="attendenteTeachers">{{$attendenceTeachers}}</span>
            </button>
        </header>
        <main class="my-4 py-4 hidden" id="mainStudents">
            <h2 class="text-center text-2xl roboto-bold my-5">Asistencia de estudiantes</h2>
            <table class="w-full">
                <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2">Hora</th>
                    <th class="py-2">Estudiante</th>
                    <th class="py-2">Cátedra</th>
                    <th class="py-2">Profesor</th>
                    <th class="py-2">Suplente</th>
                    <th class="py-2">Asistencia</th>
                </tr>
                </thead>
                <tbody>
                @foreach($studentsToday as $student)
                    <tr class="roboto-regular text-center text-lg">
                        <td class="py-1">{{ $student->hour }}</td>
                        <td class="py-1">{{ $student->name }}</td>
                        <td class="py-1">{{ $student->course }}</td>
                        <td class="py-1">{{ $student->teacher }}</td>
                        <td class="py-1"></td>
                        <td class="flex justify-center py-2"
                            id="attendenceTd_{{$student->student_id}}_{{$student->course_id}}">
                            @if ($student->asistencia)
                                <img src="{{ asset('img/icons/attendenceTrue.png') }}" alt="check" class="w-6">
                            @else
                                <button class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow"
                                        onclick="handleRegisterAttendance('{{$student->student_id}}', '{{$student->course_id}}')">
                                    <img src="{{ asset('img/icons/check.png') }}" alt="check" class="w-6">
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </main>
        <main class="my-4 py-4" id="mainTeachers">
            <h2 class="text-center text-2xl roboto-bold my-5">Asistencia de profesores</h2>
            <table class="w-full">
                <thead class="border-b-2 border-b-light_pink">
                <th class="py-2">Hora</th>
                <th class="py-2">Profesor</th>
                <th class="py-2">Cátedra</th>
                <th class="py-2">Suplente</th>
                <th class="py-2">Asistencia</th>
                </thead>
                <tbody>
                @foreach($resultsTeaches as $teacher)
                    <tr class="roboto-regular text-center text-lg">
                        <td class="py-1">{{ $teacher->hour }}</td>
                        <td class="py-1">{{ $teacher->teacher }}</td>
                        <td class="py-1">{{ $teacher->course }}</td>
                        <td class="py-1" id="subsTd_{{$teacher->teacher_id}}_{{$teacher->course_id}}">
                            @if($teacher->substitute)
                                {{ $teacher->substitute }}
                            @else
                                <button class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow"
                                        id="btnShowAddSubs_{{$teacher->teacher_id}}_{{$teacher->course_id}}"
                                        onclick="handleShowAddSubstitute('{{$teacher->teacher_id}}', '{{$teacher->course_id}}')">
                                    <img src="{{ asset('img/icons/add.png') }}" alt="check" class="w-6">
                                </button>
                                <div class="hidden flex"
                                     id="divAddSubs_{{$teacher->teacher_id}}_{{$teacher->course_id}}">
                                    <select class="input" id="selectAddSubs">
                                        <option value="">Seleccionar</option>
                                        @foreach($teachersSubstitute as $teacherSubstitute)
                                            <option value="{{ $teacherSubstitute->id }}"
                                                    value-name="{{ $teacherSubstitute->name }} {{$teacherSubstitute->last_name}}">{{ $teacherSubstitute->name }} {{$teacherSubstitute->last_name}}</option>
                                        @endforeach
                                    </select>
                                    <button class="rounded bg-purple_p p-4 mx-1"
                                            onclick="handleSetSubstitute('{{$teacher->teacher_id}}', '{{$teacher->course_id}}')">
                                        <img src="{{ asset('img/icons/checkWhite.png') }}" alt="check" class="w-6">
                                    </button>
                                </div>
                            @endif
                        </td>
                        <td class="flex justify-center py-2"
                            id="attendenceTd_{{$teacher->teacher_id}}_{{$teacher->course_id}}">
                            @if ($teacher->asistencia)
                                <img src="{{ asset('img/icons/attendenceTrue.png') }}" alt="check" class="w-6">
                            @else
                                <button class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow"
                                        onclick="handleRegisterAttendance('{{$teacher->teacher_id}}', '{{$teacher->course_id}}')">
                                    <img src="{{ asset('img/icons/check.png') }}" alt="check" class="w-6">
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </main>
    </div>

    <script>

        const handleShowMain = (main) => {
            const mainStudents = document.getElementById("mainStudents");
            const mainTeachers = document.getElementById("mainTeachers");
            if (main === "students") {
                mainStudents.style.display = "block";
                mainTeachers.style.display = "none";
            } else {
                mainStudents.style.display = "none";
                mainTeachers.style.display = "block";
            }
        }

        const handleRegisterAttendance = (studentId, groupId) => {
            console.log(studentId, groupId);
            const data = {
                student_id: studentId,
                group_id: groupId
            }
            fetch("{{ route('admin.asistencia.registrar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    const td = document.getElementById(`attendenceTd_${studentId}_${groupId}`);
                    td.innerHTML = `<img src="{{ asset('img/icons/attendenceTrue.png') }}" alt="check" class="w-6">`;
                    const attendenceStudents = document.getElementById("attendenceStudents");
                    const attendenceStudentsValue = attendenceStudents.innerHTML;
                    const currentAttendenceStudents = attendenceStudentsValue.split("/")[0];
                    attendenceStudents.innerHTML = `${parseInt(currentAttendenceStudents) + 1}/${attendenceStudentsValue.split("/")[1]}`;
                })
                .catch(error => console.error(error));
        }

        const handleShowAddSubstitute = (teacherId, courseIds) => {
            console.log(teacherId, courseIds);
            const btnShowAddSubs = document.getElementById(`btnShowAddSubs_${teacherId}_${courseIds}`);
            btnShowAddSubs.classList.toggle("hidden");
            const divAddSubs = document.getElementById(`divAddSubs_${teacherId}_${courseIds}`);
            divAddSubs.classList.toggle("hidden");
        }

        const handleSetSubstitute = (teacherId, courseIds) => {
            console.log(teacherId, courseIds);
            const selectAddSubs = document.getElementById("selectAddSubs");
            console.log(selectAddSubs.value);
            if (selectAddSubs.value !== "") {
                const data = {
                    teacher_id: teacherId,
                    group_id: courseIds,
                    substitute_id: selectAddSubs.value
                }
                fetch("{{ route('admin.asistencia.suplente') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        const td = document.getElementById(`subsTd_${teacherId}_${courseIds}`);
                        td.innerHTML = selectAddSubs.options[selectAddSubs.selectedIndex].getAttribute("value-name");
                    })
                    .catch(error => console.error(error));

            }

        }
    </script>

@endsection
