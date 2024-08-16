@extends("academia.layout.app")

@section("content")
<div>
    <div class="">
        <a href="/admin/estudiantes/{{$student->id}}/pagos/agregar">
            <button class="bg-purple_p text-white rounded-md px-4 py-2">Nuevo pago</button>
        </a>
    </div>
    @if(count($pagos) > 0)
    <div class="my-4">
    
    </div>
    @else
    <div class="my-4">
        <h1 class="text-xl roboto-regular text-center">No hay pagos registrados</h1>
    </div>
    @endif

</div>
@endsection