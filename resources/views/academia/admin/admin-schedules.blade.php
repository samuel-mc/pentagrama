@extends("academia.layout.app")

@section("content")
    <div>
        <section>
            <table class="w-full">
                <thead class="border-b-2 border-purple_p">
                {{-- Se itera sobre la lista de dias --}}
                @foreach($days as $day)
                    <th class="text-lg text-purple_p py-2">{{$day}}</th>
                @endforeach
                </thead>
                <tbody>
                {{-- Se itera sobre la lista de horarios --}}
                @foreach($schedule as $key =>$scheduleItem)
                    <tr style="border-bottom: 1px solid #ff6cd7">
                        <td>
                            {{-- Se imprime el horario --}}
                            {{$key}}
                        </td>
                        {{-- Se itera sobre los horarios de cata dia --}}
                        @foreach($scheduleItem as $courses)
                            <td class="text-center py-2">
                                {{-- Se itera sobre los cursos de cada hora --}}
                                @foreach($courses as $course)
                                    <div>
                                        @if($course == "")
                                            <a href="{{route('admin.horarios.agregar', ["day" => $loop->parent->index, "hour" => $key, 'selectedStudent' => $selectedStudent])}}"
                                               class="text-light_pink hover:text-purple_p transition-all">
                                                Agregar
                                            </a>
                                        @else
                                            <span>
                                                {{$course}}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </div>
@endsection
