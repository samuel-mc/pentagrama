@extends("academia.layout.app")

@section("content")
<div>
    <section class="flex flex-wrap my-4">
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Estudiante</h3>
            <p class="text-xl text-black_p">{{$student->name}} {{$student->last_name}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Fecha de pago</h3>
            <p class="text-xl text-black_p">{{$student->formattedPaymentDate}}</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Monto mensual</h3>
            <p class="text-xl text-black_p">{{$student->paymentsData->monthly_payment}}$</p>
        </div>
        <div class="mx-4 my-2">
            <h3 class="text-sm text-dark_pink">Inscripción</h3>
            <p class="text-xl text-black_p">{{$student->paymentsData->inscription_payment}}$</p>
        </div>
    </section>
    <section class="my-4">
        <input type="text" placeholder="Dirección" name="direccion" class="input">
        <select name="payment_type" class="input">
            <option value="">Método de pago</option>
            <option value="Pago móvil">Pago móvil</option>
            <option value="Efectivo">Efectivo</option>
        </select>
        
    </section>
</div>
@endsection