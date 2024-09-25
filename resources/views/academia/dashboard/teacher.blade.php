@extends("academia.layout.app")

@section("content")
    <div class="py-6">
        <header class="text-center my-4">
            <h2 class="text-2xl">Horario: <span class="capitalize">{{$dayName}}</span></h2>
        </header>
        <table class="mx-auto">
            <tr>
                <th class="px-5 py-1 text-lg bg-purple_p text-white_p">Horario</th>
                <th class="px-5 py-1 text-lg bg-purple_p text-white_p">Cátedra</th>
            </tr>
            @foreach($schedule as $key => $item)
            <tr class="border">
                <td class="px-5 py-1 text-lg ">{{$key}}</td>
                <td class="px-5 py-1 text-lg ">{{$item}}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="-y-6">
        <header class="text-center my-4">
            <h2 class="text-2xl">Estudiantes: <span class="capitalize">{{$dayName}}</span></h2>
        </header>
        <table class="mx-auto">
            <tr>
                <th class="px-5 py-1 text-lg bg-purple_p text-white_p">Nombre</th>
                <th class="px-5 py-1 text-lg bg-purple_p text-white_p">Cátedra</th>
                <th class="px-5 py-1 text-lg bg-purple_p text-white_p">Horario</th>
            </tr>
            @foreach($studentsByDay as $student)
            <tr class="border">
                <td class="px-5 py-1 text-lg ">{{$student->student}}</td>
                <td class="px-5 py-1 text-lg ">{{$student->course}}</td>
                <td class="px-5 py-1 text-lg ">{{$student->schedule}}</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
