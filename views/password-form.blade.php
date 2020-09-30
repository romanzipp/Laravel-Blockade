<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />

    <title>{{ config('blockade.branding.title') }}</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100">

    <div class="flex flex-col justify-center justify-between" style="height: 100vh">

        <div class="flex justify-center py-8 border-b text-xl font-bold text-blue-700">

            @if(config('blockade.branding.logo_url'))

                <img src="{{ config('blockade.branding.logo_url') }}" alt="{{ config('app.name') }}" class="h-16">

            @else

                {{ config('app.name') }}

            @endif

        </div>

        <div class="flex flex-col items-center my-8 px-8">

            <div class="flex justify-center">

                <img src="{{ asset('vendor/blockade/illustration_server_down.svg') }}" class="h-32 sm:h-64">

            </div>

            <div class="mt-12 sm:mt-16 py-8 px-12 bg-white rounded-lg shadow-xl space-y-6">

                <h1 class="text-center text-2xl sm:text-3xl font-bold">
                    {{ config('blockade.branding.title') }}
                </h1>

                <div class="space-y-1 text-gray-700 text-sm">

                    <p>
                        It looks like the page you are trying to visit is currently under construction.
                    </p>

                    <p>
                        You can still access this site if the owner has provided you a password.
                    </p>

                </div>

                <div class="flex flex-wrap justify-center">

                    <form method="post" action="">

                        <div class="flex">

                            <input type="password"
                                   name="{{ config('blockade.handlers.cookie.input_field') }}"
                                   placeholder="Password"
                                   autofocus
                                   class="px-4 py-2 bg-gray-200 rounded-l-md outline-none focus:bg-gray-300 transition-colors duration-150 placeholder-gray-600">

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 transition-colors duration-100 px-6 py-2 rounded-r-md uppercase text-sm text-white outline-none">
                                Submit
                            </button>

                        </div>

                    </form>

                </div>

                @isset($message)

                    <div class="flex justify-center">

                        <div class="mt-8 px-8 py-3 bg-red-100 text-sm text-red-800 rounded">
                            {{ $message }}
                        </div>

                    </div>

                @endisset

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
