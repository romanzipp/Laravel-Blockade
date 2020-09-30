@extends('blockade::layout.layout')

@section('content')

    <h1 class="text-center text-2xl sm:text-3xl font-bold">
        {{ trans('blockade::messages.title') }}
    </h1>

    <div class="space-y-1 text-gray-700 text-sm">

        <p>
            {{ trans('blockade::messages.descriptions.what_happened') }}
        </p>

        <p>
            {{ trans('blockade::messages.descriptions.access_with_password') }}
        </p>

    </div>

    @isset($message)

        @include('blockade::partials.error', ['message' => $message])

    @endisset

@endsection
