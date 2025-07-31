@extends('layouts.app')
@section('title', 'User Registration')
@section('description', 'Sign up to create an account on Gluto HEP')
@section('content')
    <div class="form-container">

        <a href="/"><img src="{{ asset('images/logo.png') }}" class="mx-auto h-[150px]"></a>

        <div class="form-desc">
            <h1 class="top-title">Create an Account</h1>
            <p class="text-blur-md">Welcome to Gluto HEP</p>
        </div>

        <div class="container-body" style="margin-top:30px">
            <form class="form" action="{{route('register')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" required="" value="" placeholder="Full Name"
                        name="name">
                        @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" required="" value="" placeholder="Email"
                        name="email">
                        @error('email')
                        {{ $message }}
                    @enderror
                </div>



                <div class="form-group" name="gender">
                    <select name="gender" required="" class="form-control">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    @error('gender')
                    {{ $message }}
                @enderror
                </div>

                <div class="form-group">
                    <input type="number" class="form-control" maxlength="11"
                        oninput="javascript:if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)"
                        required="" value="" placeholder="Phone Number" name="contact_no">
                        @error('contact_no')
                        {{ $message }}
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" class="form-control"
                         value="" placeholder="Address" name="address">
                         @error('adddress')
                         {{ $message }}
                     @enderror
                </div>

                <div class="form-group">
                    <input type="date" class="form-control"
                        name="dob">
                        @error('dob')
                        {{ $message }}
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" value="" placeholder="Referral Id (Optional)"
                        name="referral_id">
                        @error('referral_id')
                            {{ $message }}
                        @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" required="" value="" placeholder="Password"
                        name="password">
                    <i class="ri-eye-fill toggle-password"></i>
                    @error('password')
                    {{ $message }}
                @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" required="" value="" placeholder="Confirm Password"
                        name="password_confirmation">
                    <i class="ri-eye-fill toggle-password"></i>
                    @error('password_confirmation')
                    {{ $message }}
                @enderror
                </div>

                <div class="form-group">
                    <label>
                        <input style="accent-color: var(--main)" type="checkbox"
                            oninvalid="this.setCustomValidity('Kindly agree to our terms and condition before you can proceed')"
                            required="" name="terms_condition" oninput="this.setCustomValidity('')"> I agree to Gluto HEP
                        <a class="text-colored" target="_blank" href="">terms and conditions</a>
                    </label>
                </div>

                <div class="form-group form-group-btn">
                    <button name="create" class="form-btn">Create Account</button>
                </div>

                <div class="form-group text-center">
                    <p class="text-blur-md">Already have an account? <a class="form-link-colored" href="login">Login</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
