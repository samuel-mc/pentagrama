@extends('academia.layout.app')

@section("content")
    <div>
        <header class="text-end my-4">
            <a class="btn btn--primary" href="/admin/info-adicional/horarios-disponibles/agregar">
                <span class="roboto-bold text-white_p">+ Agregar</span>
            </a>
        </header>
        <main>
            <table class="w-full">
                <thead class="border-b-2 border-b-light_pink">
                <tr class="roboto-bold text-lg">
                    <th class="py-2"></th>
                    <th class="py-2">Hora</th>
                    <th class="py-2"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($horarios as $key => $item)
                    <tr class="roboto-regular text-center text-lg">
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->hour }}:{{$item->minute}}</td>
                        <td class="flex justify-center py-2">

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </main>
    </div>@endsection
