@extends("academia.layout.app")

@section("content")
<div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 px-4 py-10">
        <a href="/admin/estudiantes/{{$student->id}}/pagos" class="w-full">
            <button class="btn btn--primary" class="w-full">
                Pagos
            </button>
        </a>
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
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Usuario</h3>
            <p class="text-xl text-black_p">{{$student->user->email}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Nombre</h3>
            <p class="text-xl text-black_p">{{$student->name}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Apellidos</h3>
            <p class="text-xl text-black_p">{{$student->last_name}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Fecha de nacimiento</h3>
            <p class="text-xl text-black_p">{{$student->formatedBirthdate}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Género</h3>
            <p class="text-xl text-black_p">{{$student->gender}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Modalidad</h3>
            <p class="text-xl text-black_p">{{$student->modality}}</p>
        </div>
    </section>
    <section class="mb-10">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Datos del representante</h2>
        <div class="flex flex-wrap">
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">¿Cómo conoció el programa?</h3>
                <p class="text-xl text-black_p">{{$student->representative->howFoundUs->how}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Nombre</h3>
                <p class="text-xl text-black_p">{{$student->representative->name}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Apellidos</h3>
                <p class="text-xl text-black_p">{{$student->representative->last_name}}</p>
            </div>
                        <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Cédula de identidad</h3>
                <p class="text-xl text-black_p">{{$student->representative->id_card}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Número de whatsapp</h3>
                <p class="text-xl text-black_p">{{$student->representative->whatsapp_number}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Número de emergencia</h3>
                <p class="text-xl text-black_p">{{$student->representative->another_number}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Ocupación</h3>
                <p class="text-xl text-black_p">{{$student->representative->occupation}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Dirección</h3>
                <p class="text-xl text-black_p">{{$student->representative->address}}</p>
            </div>
        </div>
    </section>
    <section class="mb-10">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Pago</h2>
        <div class="flex flex-wrap">
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Método de pago</h3>
                <p class="text-xl text-black_p">{{$student->paymentsData->payment_method}}</p>
            </div>
                        <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Monto mensual</h3>
                <p class="text-xl text-black_p">{{$student->paymentsData->monthly_payment}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Inscripción</h3>
                <p class="text-xl text-black_p">{{$student->paymentsData->inscription_payment}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Fecha</h3>
                <p class="text-xl text-black_p">{{$student->formatedPaymentDate}}</p>
            </div>
        </div>
    </section>
</div>
@endsection