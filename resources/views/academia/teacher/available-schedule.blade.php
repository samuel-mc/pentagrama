@extends('academia.layout.app')

@section('content')
    <div>
        <section>
            <table class="w-full">
                <thead class="border-b-2 border-purple_p">
                {{-- Se itera sobre la lista de dias. --}}
                @for($i = 0; $i < 1; $i++)
                    @foreach($days as $day)
                        <th class="text-lg text-purple_p py-2">{{$day}}</th>
                    @endforeach
                @endfor
                </thead>
                <tbody>
                {{-- Se itera sobre la lista de horarios --}}
                @foreach($availableSchedules as $key =>$scheduleItem)
                    <tr style="border-bottom: 1px solid #ff6cd7">
                        <td>
                            {{-- Se imprime el horario --}}
                            {{$key}}
                        </td>
                        {{-- Se itera sobre los horarios de cata dia --}}
                        @foreach($scheduleItem as $availability)
                            <td class="text-center py-2">
                                @if($availability->name == "Disponible")
                                    <a class="text-green-500 hover:text-green-700 hover:underline transition-all hover:cursor-pointer"
                                       href="{{route('admin.profesores.horarios-disponibles.agregar', ['teacherId'=>$teacherId, 'timeSlotId'=>$availability->time_slot_id, 'day'=>$availability->day_of_week])}}">
                                        Disponible
                                    </a>
                                @elseif($availability->name == "No disponible")
                                    <a class="text-red-500 hover:text-red-700 hover:underline transition-all hover:cursor-pointer"
                                       href="{{route('admin.profesores.horarios-disponibles.agregar', ['teacherId'=>$teacherId, 'timeSlotId'=>$availability->time_slot_id, 'day'=>$availability->day_of_week])}}">
                                        No disponible
                                    </a>
                                @else
                                    <span>
                                    {{$availability->name}}
                                </span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </section>
        <section class="py-6">
            <h2 class="text-2xl my-4">Cátedras que puede dar</h2>
            <ul class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-8">
                @foreach($courses as $course)
                    <li>
                        <a href="{{route('admin.cursos-por-profesor.agregar', ['teacherId'=>$teacherId, 'courseId'=>$course->id])}}"
                           class="{{$course->selected ? "text-green-500 hover:text-green-700" : "text-red-500 hover:text-red-700"}} hover:underline transition-all">
                            {{$course->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
