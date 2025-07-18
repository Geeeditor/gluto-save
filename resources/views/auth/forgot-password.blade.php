

@extends('layouts.app')
@section('title', '')
@section('description', '')
@section('content')
    <div class="form-container">

        <a href="home"><img src="{{ asset('images/logo.png') }}" class="mx-auto"></a>

        <div class="form-desc">
            <h1 class="top-title">Password Reset</h1>
            <div class="mb-4 text-gray-600 text-sm">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
        </div>



        <div class="container-body" style="margin-top:30px">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex justify-end items-center mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection

