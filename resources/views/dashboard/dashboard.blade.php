@extends('layouts.auth')
@section('style')
    <link rel="stylesheet" href="{{asset('css/dashboard/style.css')}}">
@endsection

@section('content')
    {{-- Notifyables --}}
    <style>
        @keyframes flash {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .flash {
        animation: flash 1s ease-in-out;
    }
    </style>

    <div id="notification-section" class="">
        @if($notificationData)
            @foreach($notificationData as $notification)
                <div class="mt-0 alert alert-info">
                    {{-- {{dd($notification)}} --}}
                    <strong>{{ $notification['title'] }}:</strong> {{ $notification['message'] }}
                </div>
            @endforeach
        @else
            <div class="mt-0 alert alert-danger">
                <strong>You have no notifications at this time</strong>!
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notificationSection = document.getElementById('notification-section');

            // Check if there are notifications
            if (notificationSection.children.length > 0) { // Ensure there are notifications
                notificationSection.classList.add('flash');

                // Remove the flash class and hide the section after the animation is done
                setTimeout(() => {
                    notificationSection.classList.remove('flash');
                    notificationSection.style.display = 'none'; // Hide the section
                }, 5000); // Match this duration with the CSS animation duration
            }
        });
    </script>



    <div class="mt-5">
        <div class="d-flex grid-lists">
            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/dollar-bag.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Wallet Balance <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>
                    <h2 class="m-0 text-blur">₦0.00</h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- This Shows Your Current Funding Balance.</p>
            </div>
            </div>

            {{-- <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/dollar-bag.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Liquid Balance <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>
                    <h2 class="m-0 text-blur">₦0.00</h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- This Shows Your Current Withdrawable Amount.</p>
            </div>
            </div> --}}

            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/user-group.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Total Referals <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>
                    <h2 class="m-0 text-blur">0</h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- This Shows The Total Number of Referrals You Have.</p>
            </div>
            </div>

            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/dollar-bag-rise.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Total Contribution <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>

                    <h2 class="m-0 text-blur">6</h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                    <p class="text-xs poppins-light">- This Shows The Total Number of Contributions You Have Made On This Package.</p>
                </div>
            </div>

            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/noble-debts-images.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Total Debts <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>
                    <h2 class="m-0 text-blur">₦0 </h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- This Shows The Total Amount of Missed Weekly Payment Yet To Be Made.</p>
            </div>
            </div>

            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/dollar-bag-rise.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Total Thrift Account <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>

                    <h2 class="m-0 text-blur">6</h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- This Shows The Total Number of Thrift Accounts You Have Created.</p>
                </div>
            </div>

            <!-- <div class="d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/coin.png') }}">
                <div>
                <h6 class="mb-2 text-md-bold color2">Total Earnings</h6>
                <h2 class="m-0 text-blur">NGN 0</h2>
                </div>
                </div> -->



            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/target.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Active Plan(s) <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>
                    <h2 class="m-0 text-blur">0</h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- This Shows The Total Number of Active Plans You Have.</p>
            </div>
            </div>
            @php
                use Carbon\Carbon;

// Subscription date (today)
$subscriptionDate = Carbon::now();

// Maturity date (52 weeks from today)
$maturityDate = $subscriptionDate->copy()->addWeeks(52);

// Calculate the remaining weeks until maturity date
$remainingWeeks = $subscriptionDate->diffInWeeks($maturityDate);

// Output the maturity date and remaining weeks
$maturityDateFormatted = $maturityDate->format('m/d/Y');
            @endphp

            <div x-data="{ tooltip: false }" class="relative d-flex grid-col-4 grid-col-4 align-center">
                <img style="width:60px" src="{{ asset('assets/images/target.png') }}">
                <div>
                    <h6 class="mb-2 text-md-bold">Maturity Date <span @click="tooltip = !tooltip" class="mdi-information-box-outline mdi"></span></h6>
                    <h2 class="m-0 text-blur">{{ $maturityDateFormatted }} </h2>
                </div>
                <div x-transition x-show="tooltip" @click.outside="tooltip = false"
                class="hover:block top-6 left-0 z-10 absolute bg-white shadow-lg p-2 rounded-md w-full text-black">
                <p class="text-xs poppins-light">- Your subscription maturity date is in {{ $remainingWeeks }} weeks.</p>
            </div>
            </div>














            <div class="grid-col-4 grid-col-4 d-fle d-none align-center">
                <img style="width:60px" src="https://cdn-icons-png.flaticon.com/128/4285/4285550.png">
                <div>
                    <h6 class="mb-2 text-md-bold color3">Current Thrift Weeks</h6>
                    <h2 class="m-0 text-blur">
                        0 </span>
                    </h2>
                </div>
            </div>


        </div>

    </div>


@endsection
