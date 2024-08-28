@extends("academia.layout.app")

@section("content")
<div>

    <section>
        @if (session("success"))
        <div class="bg-green-200 p-4 my-4 rounded">
            {{session("success")}}
        </div>
        @endif
    </section>

    <section class="py-4">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Estudiante</h2>

        <div class="flex flex-wrap">
            <div class="flex items-center">
                <img src="{{$student->photo}}" alt="user" class="w-12 rounded-full">
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
                <h3 class="text-sm text-dark_pink">Edad</h3>
                <p class="text-xl text-black_p">{{$student->age}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Cátedras que cursa</h3>
                <p class="text-xl text-black_p">{{$student->courses}}</p>
            </div>
    </section>

    <section class="py-4">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Representante</h2>

        <div class="flex flex-wrap">
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Nombre</h3>
                <p class="text-xl text-black_p">{{$student->representative->name}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Apellidos</h3>
                <p class="text-xl text-black_p">{{$student->representative->last_name}}</p>
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
                <h3 class="text-sm text-dark_pink">Correo</h3>
                <p class="text-xl text-black_p">{{$student->representative->email}}</p>
            </div>
        </div>
    </section>
    <section class="py-4">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Datos de pago</h2>
        @foreach ($student->studentsGroups as $group)
        <div class="flex flex-wrap">
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Grupo</h3>
                <p class="text-xl text-black_p">{{$group->group->name}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Cátedra</h3>
                <p class="text-xl text-black_p">{{$group->group->course->name}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Monto</h3>
                <p class="text-xl text-black_p">{{$group->monthly_payment}}$</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Fecha de pago</h3>
                <p class="text-xl text-black_p">{{$group->formattedPaymentDate}}</p>
            </div>
        </div>
        @endforeach
    </section>
    <section class="py-4">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Login</h2>
        <div class="flex flex-wrap">
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Correo</h3>
                <p class="text-xl text-black_p">{{$student->user->email}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Contraseña</h3>
                <form action="{{route("admin.estudiantes.password", ["id"=>$student->id])}}" method="POST">
                    <div>
                        @csrf
                        <input type="password" name="password" class="border border-gray-300 rounded-lg p-2" onkeyup="handleChangePassword()" id="inputPassword">
                        <button type="submit" class="bg-gray-600 text-white rounded-lg p-2" id="buttonSubmit" disabled>Cambiar contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="py-4">
        <h2 class="text-2xl not-serif-regular text-purple_p my-4">Pagos</h2>
        @foreach ($student->paymentsDone as $payment)
        <div class="flex flex-wrap">
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Fecha</h3>
                <p class="text-xl text-black_p">{{$payment->date}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Método de pago</h3>
                <p class="text-xl text-black_p">{{$payment->method}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Monto</h3>
                <p class="text-xl text-black_p">{{$payment->amounts}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Monto total</h3>
                <p class="text-xl text-black_p">{{$payment->amountTotal}}</p>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Capture</h3>
                    <a href="" class="text-xl text-purple_p">Consultar</a>
            </div>
            <div class="mx-4 my-2">
                <h3 class="text-sm text-dark_pink">Validado</h3>
                <p class="text-xl text-black_p">{{$payment->validate ? "Validado" : "No validado"}}</p>
            </div>
        </div>
        @endforeach
    </section>

</div>

</div>
<script>
    const handleChangePassword = () => {
        const inputPassword = document.getElementById("inputPassword");
        const buttonSubmit = document.getElementById("buttonSubmit");
        console.log(inputPassword.value);

        if (inputPassword.value.length > 0) {
            buttonSubmit.removeAttribute("disabled");
            buttonSubmit.classList.remove("bg-gray-600");
            buttonSubmit.classList.add("bg-purple_p");
        } else {
            buttonSubmit.setAttribute("disabled", true);
            buttonSubmit.classList.remove("bg-purple_p");
            buttonSubmit.classList.add("bg-gray-600");
        }
    }
</script>

@endsection