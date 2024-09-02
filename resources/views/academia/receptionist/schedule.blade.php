@extends("academia.layout.app")

@section("content")
    <div>
        <section>
            <table class="w-full">
                <thead class="border-b-2 border-purple_p">
                @foreach($days as $day)
                    <th class="text-lg text-purple_p py-2">{{$day}}</th>
                @endforeach
                </thead>
                <tbody>
                @foreach($scheduleReceptionist as $hours)
                    <tr class="border-b-2 border-light_pink">
                        @foreach($hours as $key => $item)
                            <td class="py-2 text-center"
                                style="border-left: 1px solid #00000075; border-right: 1px solid #00000075">
                                {{$item}} <br>
                                @if($key != 0)
                                    <a href="{{route('admin.grupos.agregar')}}"
                                       class="text-light_pink hover:text-purple_p transition-all">
                                        Agregar
                                    </a>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
        <section class="text-end">
            <ul class="py-2">
                @foreach($ages as $age)
                    <li class="my-1">{{$age->name}} ({{$age->description}}) {{$age->min_age}} a {{$age->max_age}} años</li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection
