@extends('academia.layout.app')

@section("content")
    <div>
        <div>
            @if ($errors->any())
                <ul class="list-disc list-inside w-full bg-red-100 border-2 border-red-500 rounded p-2 my-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <form action="/admin/info-adicional/horarios-disponibles/agregar" method="POST" id="formAddHorario">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-2">
                <div>
                    <h3 class="text-sm mb-1 text-light_pink">Hora</h3>
                    <select name="hour" class="input">
                        <option value="" selected disabled>Selecciona una hora</option>
                        @for($i = 6; $i < 23; $i++)
                            <option value="{{ $i }}">{{ $i < 10 ? "0".$i : $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <h3 class="text-sm mb-1 text-light_pink">Minuto</h3>
                    <select name="minute" class="input">
                        <option value="" selected disabled>Selecciona un minuto</option>
                        @for($i = 0; $i < 12; $i++)
                            <option value="{{ $i*5 }}">{{ $i*5 < 10 ? "0".$i*5 : $i*5 }}</option>
                        @endfor
                    </select>
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
            window.location.href = "/admin/info-adicional/horarios-disponibles";
        }
    </script>
@endsection
