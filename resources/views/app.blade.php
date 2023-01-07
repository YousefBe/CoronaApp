<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
              integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
              crossorigin=""/>
        <link
            rel="stylesheet"
            type="text/css"
            href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.22.1/maps/maps.css"
        />
        <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.22.1/maps/maps-web.min.js"></script>
        <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.22.1/services/services-web.min.js"></script>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.22.1/services/services-web.min.js"></script>
    </body>
</html>
