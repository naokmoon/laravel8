@extends('layouts.app')

@section('content')
    <h1>{{ __('messages.welcome') }}</h1>

    <p>{{ __('messages.example_with_value', ['name' => 'John']) }}</p>

    <p>{{ trans_choice('messages.plural', 0) }}</p>
    <p>{{ trans_choice('messages.plural', 1) }}</p>
    <p>{{ trans_choice('messages.plural', 10) }}</p>

    <p>Using JSON: {{ __('Welcome to Laravel!') }}</p>
    <p>Using JSON: {{ __('Hello :name', ['name' => 'Piotr']) }}</p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
@endsection
