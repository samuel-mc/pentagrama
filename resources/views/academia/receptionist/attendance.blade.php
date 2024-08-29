@extends("academia.layout.app")

@section("content")
<div>
    <header class="grid grid-cols-2 gap-4">
        <button class="btn btn--primary">Estudiantes <span id="attendenceStudents">{{$attendenceStudents}}</span></button>
        <button class="btn btn--primary">Profesores 6/7</button>
    </header>
    <main class="my-4 py-4">
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
                    <td class="flex justify-center py-2" id="attendenceTd_{{$student->student_id}}_{{$student->course_id}}">
                        @if ($student->asistencia)
                            <img src="{{ asset('img/icons/attendenceTrue.png') }}" alt="check" class="w-6">
                        @else
                            <button class="bg-white hover:bg-light_pink transition-all rounded p-2 shadow" onclick="handleRegisterAttendance('{{$student->student_id}}', '{{$student->course_id}}')">
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
</script>

@endsection