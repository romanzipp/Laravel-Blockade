@extends('blockade::layout.layout')

@section('content')

    <h1 class="text-center text-2xl sm:text-3xl font-bold dark:text-white">
        {{ trans('blockade::messages.title') }}
    </h1>

    <div class="space-y-1 text-sm text-gray-700 dark:text-gray-300">

        <p>
            {{ trans('blockade::messages.descriptions.what_happened') }}
        </p>

        <p>
            {{ trans('blockade::messages.descriptions.access_with_password') }}
        </p>

    </div>

    <div class="flex flex-wrap justify-center">

        <form method="post" action="{{ route('blockade.validate') }}" class="w-full sm:w-auto">

            <input type="hidden" name="return_to" value="{{ $returnTo }}">

            <div class="flex flex-col sm:flex-row">

                <input type="password"
                       name="{{ config('blockade.handlers.form.input_field') }}"
                       placeholder="{{ trans('blockade::messages.password') }}"
                       class="px-4 py-2 bg-gray-200 text-center sm:text-left text-sm rounded-t-md sm:rounded-t-none sm:rounded-l-md outline-none focus:bg-gray-300 transition-colors duration-150 placeholder-gray-500"
                       autofocus>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition-colors duration-100 px-6 py-2 rounded-b-md sm:rounded-b-none sm:rounded-r-md uppercase text-sm text-white outline-none">
                    {{ trans('blockade::messages.submit') }}
                </button>

            </div>

        </form>

    </div>

    @isset($message)

        @include('blockade::partials.error', ['message' => $message])

    @endisset

@endsection
