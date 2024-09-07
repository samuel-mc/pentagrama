<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title }}</title>
    @vite('resources/css/app.css')
</head>

<body class="grid grid-cols-12 bg-white_p">
    <aside class="col-span-2 min-h-screen">
        <section class="py-10">
            <div class="bg-white rounded-full w-fit p-5 mx-auto">
                <img src="{{ asset('img/logo2.png') }}" alt="logo" class="w-8 mx-auto">
            </div>
        </section>
        <nav class="py-4 px-10">
            <ul>
                @foreach($links as $link)
                <li class="flex items-center py-4">
                    <img src="{{ asset('img/icons/'.$link->icon) }}" alt="icon" class="w-6 mr-4">
                    <a href="{{$link->url}}" class=" text-xl roboto-medium hover:text-purple_p transition-all">{{$link->name}}</a>
                </li>
                @endforeach
            </ul>
        </nav>
    </aside>
    <section class="col-span-10 px-10 py-5">
        <header class="flex justify-between items-center px-10 py-2 rounded-tr-2xl rounded-tl-2xl mb-2">
            <section>
                <h1 class="text-2xl roboto-medium text-purple_p">{{$title}}</h1>
            </section>
            <section class="flex items-center">
                <div class="text-right mr-4">
                    <h2 class="text-lg roboto-medium">{{$name}}</h2>
                    <h3 class="text-md roboto-regular text-dark_pink">{{$rol}}</h3>
                </div>
                <div>
                    @isset($photo)
                    <img src="{{ asset($photo) }}" alt="user" class="w-12 rounded-full">
                    @endisset
                </div>
            </section>
        </header>
        <main class="bg-white px-10 py-4 pt-10 mb-4 rounded-2xl rounded-bl-2xl shadow">
            @yield("content")
        </main>
    </section>
</body>

</html>
