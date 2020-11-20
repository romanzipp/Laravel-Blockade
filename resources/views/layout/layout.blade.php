<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="robots" content="noindex" />

    <title>{{ trans('blockade::messages.title') }}</title>

    <link href="{{ $cssAsset }}" rel="stylesheet">

</head>
<body class="bg-gray-100 dark:bg-gray-900">

    <div class="flex flex-col justify-center justify-between" style="height: 100vh">

        <div class="flex justify-center py-8 border-b border-gray-300 dark:border-gray-800 text-xl font-bold text-blue-700">

            @if(config('blockade.branding.logo_url'))

                <img src="{{ asset(config('blockade.branding.logo_url')) }}" alt="{{ config('app.name') }}" class="h-12">

            @else

                {{ config('app.name') }}

            @endif

        </div>

        <div class="flex flex-col items-center my-8 sm:px-8">

            <div class="flex justify-center">

                <img src="{{ asset('vendor/blockade/illustration_server_down.svg') }}"
                     alt="Blockade Under Construction Illustration"
                     class="block dark:hidden h-32 sm:h-64">

                <img src="{{ asset('vendor/blockade/illustration_server_down_dark.svg') }}"
                     alt="Blockade Under Construction Illustration"
                     class="hidden dark:block h-32 sm:h-64">

            </div>

            <div class="w-full sm:w-auto mt-12 sm:mt-16 py-8 px-12 bg-white dark:bg-gray-800 sm:rounded-lg shadow-xl space-y-6">

                @yield('content')

            </div>

        </div>

        <div class="py-8 border-t border-gray-300 dark:border-gray-800">

            <div class="container mx-auto space-y-4 text-xs text-center text-gray-600 ">

                <div>
                    {{ config('app.name') }}
                </div>

                @if( ! $cssAssetLocal)
                    <div>
                        <a href="https://github.com/romanzipp/Laravel-Blockade#assets" class="text-red-600 font-semibold" rel="nofollow">
                            DEVELOPER NOTICE
                        </a>
                    </div>
                @endif

            </div>

        </div>

    </div>

</body>
</html>
