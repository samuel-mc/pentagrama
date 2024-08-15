@extends("academia.layout.app")

@section("content")
<div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 px-4 py-10">
        <button class="btn btn--primary">
            Pagos
        </button>
        <button class="btn btn--primary">
            Bitácora
        </button>
        <button class="btn btn--primary">
            Editar
        </button>
    </div>
    <section class="flex flex-wrap mb-10">
        <div class="flex items-center">
            <img src="{{ asset('img/icons/avatar.png') }}" alt="user" class="w-12">
        </div>
        @include("components.detail-item", ["label" => "Usuario", "value" => "smedina"])
        @include("components.detail-item", ["label" => "Nombre", "value" => "Samuel"])
        @include("components.detail-item", ["label" => "Apellidos", "value" => "García Guzmán"])
        @include("components.detail-item", ["label" => "Fecha de nacimiento", "value" => "12/12/1999"])
        @include("components.detail-item", ["label" => "Género", "value" => "Masculino"])
        @include("components.detail-item", ["label" => "Modalidad", "value" => "Regular"])
    </section>
    <section class="mb-10">
        <h2 class="text-2xl not-serif-regular text-dark_pink my-4">Datos del representante</h2>
        <div class="flex flex-wrap">
            @include("components.detail-item", ["label" => "¿Cómo conoció el programa?", "value" => "Facebook"])
            @include("components.detail-item", ["label" => "Nombre", "value" => "Samuel"])
            @include("components.detail-item", ["label" => "Apellidos", "value" => "García Guzmán"])
            @include("components.detail-item", ["label" => "Cédula de identidad", "value" => "123456789"])
            @include("components.detail-item", ["label" => "Número de whatsapp", "value" => "123456789"])
            @include("components.detail-item", ["label" => "Número de emergencia", "value" => "123456789"])
            @include("components.detail-item", ["label" => "Ocupación", "value" => "Estudiante"])
            @include("components.detail-item", ["label" => "Dirección", "value" => "Calle 2, casa 2"])
        </div>
    </section>
    <section class="mb-10">
        <h2 class="text-2xl not-serif-regular text-dark_pink my-4">Pago</h2>
        <div class="flex flex-wrap">
            @include("components.detail-item", ["label" => "Método de pago", "value" => "Pago móvil"])
            @include("components.detail-item", ["label" => "Monto mensual", "value" => "100.000 Bs"])
            @include("components.detail-item", ["label" => "Inscripción", "value" => "50.000 Bs"])
            @include("components.detail-item", ["label" => "Fecha", "value" => "12/12/2021"])
        </div>
    </section>
</div>
@endsection