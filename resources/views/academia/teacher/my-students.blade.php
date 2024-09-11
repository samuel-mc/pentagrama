@extends('academia.layout.app')

@section('content')
    <div>
        <table class="w-full">
            <thead class="border-b-2 border-b-light_pink">
            <tr class="roboto-bold text-lg">
                <th class="py-2">Nombre</th>
                <th class="py-2">Cátedra</th>
                <th class="py-2">Horario</th>
            </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr class="roboto-regular text-center text-lg">
                    <td class="py-2">{{ $group->student }}</td>
                    <td class="py-2">{{ $group->course }}</td>
                    <td class="py-2">
                        @foreach($group->schedule as $scheduleItm)
                            <span>{{$scheduleItm->day}} {{$scheduleItm->hour}} </span>

                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
