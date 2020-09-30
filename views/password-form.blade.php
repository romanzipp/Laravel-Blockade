<!DOCTYPE html>
<html>
<head>
    <title>{{ config('blockade.title', 'Under Construction') }}</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

</head>
<body>

    <div class="container mx-auto">

        <h1 class="mb-4 text-center text-5xl font-bold">
            {{ config('blockade.title', 'Under Construction') }}
        </h1>

        <div class="mb-8 text-center text-gray-600 text-xs">
            {{ config('app.url') }}
        </div>

        <div class="flex flex-wrap justify-center">

            <form method="post" action="">

                <input type="password"
                       name="{{ config('blockade.handlers.cookie.input_field') }}"
                       placeholder="Password"
                       autofocus
                       class="px-4 py-2 bg-gray-100">

                <button type="submit" class="bg-blue-600 px-6 py-2 rounded uppercase text-sm text-white">
                    Submit
                </button>

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

</body>
</html>
