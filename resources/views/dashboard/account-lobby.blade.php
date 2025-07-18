@extends('layouts.app')
@section('title', 'Dashboard Lobby')
@section('description', 'Your payment has been processed but pending confirmation. Please wait for the admin to confirm your payment before you can access the dashboard features.')
@section('content')
    <div class="relative py-5 signup">
        <div class="top-desc mb-5">
            <h1 class="top-title">Dashboard Lobby</h1>
        </div>

        <div class="mx-auto my-5 md:w-[70%] welcome-modal">
            <div class="bg-gray-100 shadow-gray-300 shadow-md mx-auto pt-2 rounded-md main-container">

                <div class="py-5">
                    <h3 align="center " class="poppins-bold" >
                        Hi, {{$user->name}}!
                    </h3>

                    {{-- {{dd($payment)}} --}}
                            @if ($payment->payment_status === 'pending')
                                <div id="lottie-pending" class="mx-auto w-[200px] md:w-[400px]"></div>
                                <p class="mx-auto w-[50%] font-[700] text-center">
                                    Your payment has been processed but pending confirmation. Please wait for the admin to confirm your payment before you can access the dashboard features.
                                 </p>

                            @elseif ($payment->payment_status === 'approved')
                            <div id="lottie-approved" class="mx-auto w-[200px] md:w-[400px]"></div>
                            <p class="mx-auto w-[50%] font-[700] text-center">
                                Your payment was was successfully processed. You can now access the dashboard features.
                             </p>
                             <button class="bg-green-500 hover:bg-green-600 mx-auto mt-4 px-4 py-2 rounded w-[50%] font-bold text-white transition duration-300 ease-in-out" onclick="window.location.href='{{ route('dashboard') }}'">
                                Go To Dashboard
                            </button>
                            @else
                                <div id="lottie-failed" class="mx-auto w-[200px] md:w-[400px]"></div>
                                <p class="mx-auto w-[50%] font-[700] text-center">
                                    We couldn't process your payment. Please try again or contact support for assistance.
                                 </p>
                                 <button class="bg-red-500 hover:bg-red-600 mx-auto mt-4 px-4 py-2 rounded w-[50%] font-bold text-white transition duration-300 ease-in-out" onclick="window.location.href='{{ route('dashboard.account') }}'">
                                        Retry Payment
                                 </button>
                            @endif




                </div>

            </div>
        </div>

    </div>
@endsection
