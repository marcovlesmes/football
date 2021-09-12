<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Football</title>
        <!-- Fonts -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Scripts -->
        <script src="{{ asset('js/main.js') }}"></script>

    </head>
    <body>
        <h1 class="text-4xl text-green-600 font-bold text-center">Football Players</h1>
        <div id="container" class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4 xl:w-4/5 xl:mx-auto">
            <div class="md:w-2/4 md:col-span-3 xl:col-span-4 md:mx-auto xl:w-1/4">
                <form id="teamForm" class="flex flex-col p-4" action="{{ route('search.team') }}" method="POST">
                    <label class="text-xl text-green-600 font-bold" for="team">Search team</label>
                    <input class="p-2 rounded" type="text" name="name" id="team" placeholder="Real Madrid">
                    <button onclick="window.search_team(event)" class="p-2 bg-green-600 text-gray-100 my-2 rounded">Buscar</button>
                </form>
            </div>
        </div>
    </body>
</html>
