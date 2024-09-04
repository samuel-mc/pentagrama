<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white_p flex justify-center items-center w-full min-h-screen">
<div class="bg-white rounded py-10 px-10 shadow" style="width: 55%; min-width: 240px; max-width: 720px">
    <div class="my-10">
        <div class="shadow-inner rounded-full w-fit p-5 bg-white_p mx-auto">
            <img src="{{ asset('img/logo2.png') }}" alt="logo" class="w-8 mx-auto">
        </div>
        <h1 class="text-purple_p text-2xl text-center">Iniciar sesión</h1>
    </div>
    <div>
        @if (session('error'))
            <div class="bg-red-100 text-red-500 p-3 rounded my-5">
                <p class="p-4">
                {{ session('error') }}

                </p>
            </div>

        @endif

        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="my-5">
                <h3 class="text-sm mb-1 text-light_pink">Username</h3>
                <input type="username" name="username" id="username" required class="input w-full">
            </div>
            <div class="my-5">
                <h3 class="text-sm mb-1 text-light_pink">Password</h3>
                <input type="password" name="password" id="password" required class="input w-full">
            </div>
            <div class="text-center my-5">
                <button type="submit" class="btn btn--primary">Iniciar sesión</button>
            </div>
        </form>
    </div>
</div>

</body>
