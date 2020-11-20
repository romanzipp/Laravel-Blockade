<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="robots" content="noindex" />

    <title>{{ trans('blockade::messages.title') }}</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100">

    <div class="flex flex-col justify-center justify-between" style="height: 100vh">

        <div class="flex justify-center py-8 border-b text-xl font-bold text-blue-700">

            @if(config('blockade.branding.logo_url'))

                <img src="{{ asset(config('blockade.branding.logo_url')) }}" alt="{{ config('app.name') }}" class="h-12">

            @else

                {{ config('app.name') }}

            @endif

        </div>

        <div class="flex flex-col items-center my-8 px-8">

            <div class="flex justify-center">

                <img src="{{ asset('vendor/blockade/illustration_server_down.svg') }}" class="h-32 sm:h-64">

            </div>

            <div class="mt-12 sm:mt-16 py-8 px-12 bg-white rounded-lg shadow-xl space-y-6">

                @yield('content')

            </div>

        </div>

        <div class="py-8 border-t border-gray-400">

            <div class="container mx-auto text-xs text-center text-gray-700">
                {{ config('app.name') }}
            </div>

        </div>

    </div>

</body>
</html>
