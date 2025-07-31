@extends('layouts.app')
@section('title', 'User Login')
@section('description', 'Login to your account')
@section('content')
    <div class="form-container">

        <a href="/"><img src="images/logo.png" class="mx-auto h-[150px]"></a>

        <div class="form-desc">
            <h1 class="top-title">Login to your Account</h1>
            <p class="text-blur-md">Enter your details to access your account</p>
        </div>



        <div class="container-body" style="margin-top:30px">
            <form class="form" action="{{route('login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" required="" class="form-control" value=""
                        placeholder="Email Address / Phone No" name="email">
                </div>

                <div class="form-group reduce-spacing">
                    <input type="password" required="" class="form-control" placeholder="Password" name="password">
                    <i class="ri-eye-fill toggle-password"></i>
                </div>

                <div class="d-flex flex-end form-link">
                    <a class="text-blur-md" href="{{route('password.email')}}">Forget Password?</a>
                </div>

                <div class="form-group form-group-btn">
                    <button name="login" class="form-btn">Login</button>
                </div>

                <div class="form-group m-none text-center">
                    <p class="text-blur-md">Don't have an account? <a class="form-link-colored" href="{{route('register')}}">Register</a>
                    </p>
                </div>


            </form>
        </div>
    </div>
@endsection
