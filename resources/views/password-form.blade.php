@extends('blockade::layout.layout')

@section('content')

    <h1 class="text-center text-2xl sm:text-3xl font-bold">
        {{ config('blockade.branding.title') }}
    </h1>

    <div class="space-y-1 text-gray-700 text-sm">

        <p>
            {{ trans('blockade::messages.descriptions.what_happened') }}
        </p>

        <p>
            {{ trans('blockade::messages.descriptions.access_with_password') }}
        </p>

    </div>

    <div class="flex flex-wrap justify-center">

        <form method="post" action="">

            <div class="flex">

                <input type="password"
                       name="{{ config('blockade.handlers.form.input_field') }}"
                       placeholder="{{ trans('blockade::messages.password') }}"
                       autofocus
                       class="px-4 py-2 bg-gray-200 rounded-l-md outline-none focus:bg-gray-300 transition-colors duration-150 placeholder-gray-600">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition-colors duration-100 px-6 py-2 rounded-r-md uppercase text-sm text-white outline-none">
                    {{ trans('blockade::messages.submit') }}
                </button>

            </div>

        </form>

    </div>

    @isset($message)

        @include('blockade::partials.error', ['message' => $message])

    @endisset

@endsection
