<!DOCTYPE html>
<html>

<head>
    <title> Gluto (HEP) Member Dashboard | @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ env('APP_URL') . '/dashboard' }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/media.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/remixicon/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@mdi/light-font@0.2.63/css/materialdesignicons-light.min.css">
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    @yield('style')
    <style type="text/css">
        .modal-body>p:last-child {
            display: none;
        }
    </style>
    <!--End of Tawk.to Script-->
</head>

<body>

    <!-- SIDEBAR STARTS -->
    <div class="sidebar">
        <div class="sidebar-top d-flex justify-content-center">
            <a class="d-block-desktop" href="{{route('index')}}"><img
                    style="height: 100px; filter: drop-shadow(0.5px 0.5px 2.5px white);"
                    src="{{ asset('images/logo-stroke.png') }}"></a>

            <!-- SIDEBAR MOBILE USER STARTS -->
            <div class="header-right-user d-flex-mobile">
                <div class="header-right-img-wrapper">
                    <img src="{{ $profilePic }}" class="header-right-img">
                </div>

                <div class="d-flex flex-col">
                    <h6 class="mb-0 text-white-mobile text-sm-bold">{{ $user->name }}</h6>
                    <span
                        class="text-white-mobile text-sm-blur">{{ $currentSubscription ? $currentSubscription->sub_id : 'N/A' }}</span>
                    <span class="text-white-mobile text-sm-blur">(Primary Account)</span>
                    <div class="d-flex">
                        <div class="d-flex home-referral-text align-center">
                            <h6 class="m-0 text-white text-lg-bold">Referral I.D:</h6>
                            <span class="pr-1 text-white">{{ $user->referral_id }}</span>
                        </div>
                        <span class="text-white mdi-content-copy mdi" onclick="copyToClipBoard(this)"></span>
                        <textarea id="copyInput" style="display: none;">{{ $user->referral_id }}</textarea>
                    </div>
                </div>


            </div>
            <img class="d-mobile toggle-close" src="{{ asset('assets/images/times.png') }}">
            <!-- SIDEBAR MOBILE USER STARTS -->

        </div>

        <div class="d-flex flex-col sidebar-navigation">
            {{-- <form action="{{route('test.mail')}}" method="post">
                @csrf
                <button type="submit">submit</button>
            </form> --}}
            <a href="{{ route('dashboard') }}" class="d-flex sidebar-navigation-list align-center">
                <img src="{{ asset('assets/images/grid.png') }}">
                <span class="text-white">Dashboard</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>

            <div class="sidebar-dropdown">
                <a href="javascript:void();" class="d-flex sidebar-navigation-list sidebar-menu-link align-center">
                    <img src="{{ asset('assets/images/user.png') }}">
                    <span class="text-white">My Profile</span>
                    <i class="ri-arrow-right-s-line text-white nav-icon"></i>
                </a>

                <div class="d-flex flex-col dropdown-menus">
                    <a href="{{ route('dashboard.profile') }}" class="text-white sidebar-navigation-list">&raquo; Manage Profile</a>

                    <a href="{{ route('dashboard.kyc') }}" class="text-white sidebar-navigation-list">&raquo; Apply for
                        KYC</a>

                    <a href="{{ route('dashboard.kyc.status') }}" class="text-white sidebar-navigation-list">&raquo;
                        KYC Status</a>




                </div>
            </div>

            <a href="{{ route('dashboard.subscriptions') }}" class="d-flex sidebar-navigation-list align-center">
                <img src="{{ asset('/images/icons/plan.svg') }}">
                <!--<i style="font-size:15px;" class="text-white ri-file-lock-line"></i>-->
                <span class="text-white">My Plan</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>


            <a  href="{{ !is_null($settings->contribution_enabled) && $settings->contribution_enabled  ? route('dashboard.contribution') : 'javascript:void(0)' }}" class="{{!$settings->contribution_enabled ? ' cursor-not-allowed ' : ''}} d-flex  sidebar-navigation-list align-center">
                <img class="" src="{{ asset('/images/icons/contribute.svg') }}">
                <span class="text-white">Make Contribution</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>

            <a href="{{ !is_null($settings->contribution_enabled) && $settings->contribution_enabled  ?  route('dashboard.claim.status') : 'javascript:void(0)' }}" class="{{!$settings->contribution_enabled ? ' cursor-not-allowed ' : ''}} d-flex sidebar-navigation-list align-center">
                <img src="{{ asset('/images/icons/claim.svg') }}">
                <span class="text-white">Claim Contribution</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>

            <a href="{{ !is_null($settings->contribution_enabled) && $settings->contribution_enabled  ?  route('dashboard.defaulted-payment') : 'javascript:void(0)' }}" class="{{!$settings->contribution_enabled ? ' cursor-not-allowed ' : ''}} d-flex sidebar-navigation-list align-center">
                <img class="" src="{{ asset('/images/icons/default.svg') }}">
                <span class="text-white">Clear Defaulted Payment</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>




            <!--	<a href="javascript:void();" class="d-flex sidebar-navigation-list align-center" onclick="alert('Coming soon on your dashboard.');">
            <img src="assets/images/calender.png">
            <span class="text-white">Log Complain(s)</span>
            <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>-->
            <!--this end log complaints-->
            <!--this end log complaints-->
            <!--this end log complaints-->
            <!--this end log complaints-->
            <div class="sidebar-dropdown" >
                <a href="javascript:void();" class="d-flex sidebar-navigation-list sidebar-menu-link align-center">
                    <img src="{{ asset('/images/icons/withdrawal-alt.svg') }}">
                    <span class="text-white">Withdrawal</span>
                    <i class="ri-arrow-right-s-line text-white nav-icon"></i>
                </a>

                <div class="d-flex flex-col dropdown-menus">
                    {{-- <a href="javascript:void();" class="text-white sidebar-navigation-list"
                        onclick="swal('Updates Coming Soon','Please check back later','success')">&raquo; View/Delete Cashout Accounts</a> --}}
                    <a href="{{ route('dashboard.withdrawal') }}" class="text-white sidebar-navigation-list"
                       >&raquo; View/Delete Payout Accounts</a>
                    <a href="{{ route('dashboard.make-withdrawal') }}" class="text-white sidebar-navigation-list"
                        >&raquo; Make Withdrawal </a>
                    <a href="{{route('dashboard.withdrawal.history')}}" class="text-white sidebar-navigation-list"
                        >&raquo; Withdrawal History</a>

                </div>
            </div>
            <!--this end log complaints-->
            <!--this end log complaints-->
            <!--this end log complaints-->
            <!--this end log complaints-->








            <!-- settlement accounts starts here -->
            <!-- settlement accounts starts here -->
            <!-- settlement accounts starts here -->
            <!-- settlement accounts starts here -->
            <a href="{{ route('dashboard.fund') }}" class="d-flex sidebar-navigation-list align-center">
                <img src="{{ asset('/images/icons/topup.svg') }}">
                <!--<i style="font-size:15px;" class="text-white ri-file-lock-line"></i>-->
                <span class="text-white">Top Up Wallet</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>



            <a href="{{ route('dashboard.payments') }}" class="d-flex sidebar-navigation-list align-center">
                <img src="{{ asset('/images/icons/serialized.svg') }}">
                <!--<i style="font-size:15px;" class="text-white ri-file-lock-line"></i>-->
                <span class="text-white">Payment History</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a>


            {{-- <div class="sidebar-dropdown">
                <a href="{{ route('dashboard.payments') }}" class="d-flex sidebar-navigation-list sidebar-menu-link align-center">
                    <img src="{{ asset('/images/icons/serialized.svg') }}">
                    <span class="text-white">Payment History(s)</span>
                    <i class="ri-arrow-right-s-line text-white nav-icon"></i>
                </a>

                <div class="d-flex flex-col dropdown-menus">
                    <a href="{{ route('dashboard.payments') }}" class="text-white sidebar-navigation-list">&raquo;
                        Payments History</a>
                    <a href="javascript:void();" class="text-white sidebar-navigation-list">&raquo; Contribution
                        History</a>
                    <a href="" class="text-white sidebar-navigation-list">&raquo; Withdrawal History</a>
                </div>
            </div> --}}

            <!-- settlement accounts ends here -->
            <!-- settlement accounts ends here -->
            <!-- settlement accounts ends here -->
            <!-- settlement accounts ends here -->
            <!-- settlement accounts ends here -->







            <!--		<a href="wallet-transfer" class="d-flex sidebar-navigation-list align-center">
                <i style="font-size:15px;" class="text-white ri-sd-card-fill"></i>
                <span class="text-white">Wallet to Wallet Transfer</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
                </a>-->


            {{-- <a href="javascript:void();" class="d-flex sidebar-navigation-list align-center">
                <!-- <img src="assets/images/graph.png"> -->
                <i style="font-size:15px;" class="text-white ri-file-lock-line"></i>
                <span class="text-white">Settings</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
            </a> --}}

            <!-- 		<a href="wallet-transaction" class="d-flex sidebar-navigation-list align-center">
                <i style="font-size:15px;" class="text-white ri-wallet-3-line"></i>
                <span class="text-white">Wallet Transaction</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
                </a>

                <a href="thrift-transaction" class="d-flex sidebar-navigation-list align-center">
                <img src="assets/images/bag.png">
                <span class="text-white">Thrift Transaction</span>
                <i class="ri-arrow-right-s-line text-white nav-icon"></i>
                </a> -->

            <form method="POST" action="{{ route('logout') }}" class="">
                @csrf
                <button type="submit" style="background: none; border: none;"
                    class="d-flex sidebar-navigation-list spacing align-center">
                    <img src="{{ asset('assets/images/logout.png') }}">
                    <span class="text-white">Logout</span>
                </button>
            </form>

        </div>
    </div>
    <!-- SIDEBAR ENDS -->
    <div class="main-container">
        <header class="d-flex header align-center space-between">
            <a class="d-mobile mobile-logo" href="{{route('index')}}"> <img
                    style="height: 50px;  filter: drop-shadow(0.5px 0.5px 2.5px white);"
                    src="{{ asset('images/logo-stroke.png') }}"></a>

            <div class="flex-col d-flex-destop header-desc">

                <h5 class="mb-0 text-lg-bold">{{ $greeting }}, {{ $user->name }}</h5>
                @if ($currentSubscription)
                    <p class="text- text-blur">
                        Current Subscription Plan - {{ $currentSubscription->sub_id }}
                        <span style="color: #CE0016;">(Primary Account)</span>
                    </p>
                @else
                    <p class="text- text-blur">
                        {{ env('APP_NAME') }} Current Subscription Plan -
                        <span style="color: #CE0016;">N/A</span>
                    </p>
                @endif


            </div>

            <div class="header-right d-flex align-center">
                <div class="header-right-list-wrapper d-flex">
                    @if ($subscriptions->count() > 1)

                        <input type="checkbox" class="custom-check" name="">
                        <div class="header-right-dropdown-wrapper">
                            <h5 class="text-md-bold">Switch Account</h5>
                            <ul class="header-right-dropdown-menu d-flex flex-col">
                                @foreach ($subscriptions as $subscription)
                                    <li class="header-right-dropdown-list">

                                        <form
                                            action="{{ $subscription->is_primary ? 'javascript:void(0)' : route('subscription.switch') }}"
                                            method="post"
                                            class="d-flex cursor-pointer subscription-form header-dropdown-link align-center">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="sub_id"
                                                value="{{ $subscription->sub_id }}">
                                            <div class="header-dropdown-icon-wrapper">
                                                <span class="header-icon header-icon-success"
                                                    onclick="submitForm(this)">
                                                    <i class="text-white ri-check-line"></i>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-col" onclick="submitForm(this)">
                                                <h6 class="mb-0 text-sm-bold">{{ $subscription->sub_id }}</h6>
                                                <span
                                                    class="text-sm-blur">{{ $subscription->created_at->format('D, M d Y') }}
                                                    @if ($subscription->is_primary)
                                                        <span class='text-sm txt-success'>(Primary)</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </form>



                                    </li>

                                    <script>
                                        function submitForm(element) {
                                            const form = element.closest('.subscription-form'); // Get the closest form with the class
                                            const isPrimary = form.querySelector('input[name="sub_id"]').value; // Check if it's primary

                                            // Prevent submission if the subscription is primary
                                            if (!form.action.includes('javascript:void(0)')) {
                                                form.submit(); // Submit the form if not primary
                                            } else {
                                                alert('This subscription is already primary and cannot be switched.');
                                            }
                                        }

                                        // Optional: Prevent default form submission on enter key press for all forms
                                        document.querySelectorAll('.subscription-form').forEach(form => {
                                            form.addEventListener('keydown', function(event) {
                                                if (event.key === 'Enter') {
                                                    event.preventDefault();
                                                }
                                            });
                                        });
                                    </script>
                                @endforeach



                            </ul>
                        </div>
                    @endif

                </div>

                <div class="inline-flex relative justify-center items-center p-2 border border-black rounded-full">
                    <a href="{{route('dashboard.notifications')}}">
                        <img src="{{ asset('images/icons/notification.svg') }}"
                            class="w-auto h-[24px] object-center">
                    </a>
                    <span
                        class="top-0 right-0 absolute flex justify-center items-center bg-red-500 rounded-full w-5 h-5 font-bold text-white text-xs">
                        {{ count($notificationData) > 10 ? '9+' : count($notificationData) }}
                    </span>
                </div>

                <div class="header-right-user d-flex-destop">


                    <div class="header-right-img-wrapper">
                        <img src="{{ $profilePic }}" class="header-right-img">
                    </div>

                    <div class="d-flex flex-col">
                        <h6 class="mb-0 text-sm-bold">

                            {{ $user->name }}

                        </h6>
                        <span class="text-sm-blur">
                            Referral ID - {{ $user->referral_id }}
                        </span>
                    </div>
                </div>

                <img class="d-mobile toggle-open" src="{{ asset('assets/images/bar.png') }}">
            </div>

        </header>


        <div class="relative main-content-body">
            <div
                class="hidden right-0 bottom-3 z-[600] fixed space-y-6 mx-auto mt-4 w-fit md:w-[40%] flash-message tray-success animate__animated">
                @if (session()->has('success'))
                    <div class="flex items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
                        role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline fill-green-600 mr-3 w-[18px] shrink-0"
                            viewBox="0 0 512 512">
                            <ellipse cx="246" cy="246" data-original="#000" rx="246"
                                ry="246" />
                            <path class="fill-white"
                                d="m235.472 392.08-121.04-94.296 34.416-44.168 74.328 57.904 122.672-177.016 46.032 31.888z"
                                data-original="#000" />
                        </svg>
                        <span class="font-semibold text-[15px] tracking-wide">{{ session('success') }}</span>
                    </div>
                @elseif (session()->has('regsuccess') && session()->has('name'))
                    <div class="flex items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
                        role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline fill-green-600 mr-3 w-[18px] shrink-0"
                            viewBox="0 0 512 512">
                            <ellipse cx="246" cy="246" data-original="#000" rx="246"
                                ry="246" />
                            <path class="fill-white"
                                d="m235.472 392.08-121.04-94.296 34.416-44.168 74.328 57.904 122.672-177.016 46.032 31.888z"
                                data-original="#000" />
                        </svg>
                        <span class="font-semibold text-[15px] tracking-wide">
                            {{ session('regsuccess') }}
                            {{ session('name') }}
                        </span>
                    </div>
                @elseif (session()->has('info'))
                    <div class="flex items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
                        role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline fill-blue-600 mr-3 w-[18px] shrink-0"
                            viewBox="0 0 23.625 23.625">
                            <path
                                d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z"
                                data-original="#030104" />
                        </svg>
                        <span class="font-semibold text-[15px] tracking-wide">{{ session('info') }}</span>
                    </div>
                @elseif (session()->has('error'))
                    <div class="flex items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
                        role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline fill-yellow-600 mr-3 w-[18px] shrink-0"
                            viewBox="0 0 128 128">
                            <path
                                d="M56.463 14.337 6.9 106.644C4.1 111.861 8.173 118 14.437 118h99.126c6.264 0 10.338-6.139 7.537-11.356L71.537 14.337c-3.106-5.783-11.968-5.783-15.074 0z" />
                            <g class="fill-white">
                                <path
                                    d="M64 31.726a5.418 5.418 0 0 0-5.5 5.45l1.017 44.289A4.422 4.422 0 0 0 64 85.726a4.422 4.422 0 0 0 4.482-4.261L69.5 37.176a5.418 5.418 0 0 0-5.5-5.45z"
                                    data-original="#fff" />
                                <circle cx="64" cy="100.222" r="6" data-original="#fff" />
                            </g>
                        </svg>
                        <span class="font-semibold text-[15px] tracking-wide">{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class= "flex justify-end items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
                        role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline fill-red-600 mr-3 w-[18px] shrink-0"
                            viewBox="0 0 32 32">
                            <path
                                d="M16 1a15 15 0 1 0 15 15A15 15 0 0 0 16 1zm6.36 20L21 22.36l-5-4.95-4.95 4.95L9.64 21l4.95-5-4.95-4.95 1.41-1.41L16 14.59l5-4.95 1.41 1.41-5 4.95z"
                                data-original="#ea2d3f" />
                        </svg>
                        <span class="font-semibold text-[15px] tracking-wide">

                            @foreach ($errors->all() as $error)
                                <span class="block">{{ $error }} </span>
                            @endforeach
                        </span>
                    </div>
                @enderror

                <script>
                    function showFlashMessage() {
                        const flashMessage = document.querySelector('.flash-message');
                        flashMessage.classList.remove('hidden');
                        flashMessage.style.display = 'block'; // Show the message
                        flashMessage.classList.add('animate__fadeInRight'); // Add animation class

                        // Optionally, hide the message after a few seconds
                        setTimeout(() => {
                            // flashMessage.classList.remove('animate__backInRight'); // Add animation
                            flashMessage.classList.add('animate__fadeOutRight'); // Add animation
                            flashMessage.style.display = 'none'; // Hide the message after 3 seconds
                        }, 10000);
                    }

                    window.onload = function() {

                        showFlashMessage()
                    };
                </script>
        </div>




        @yield('content')

    </div>
</div>


</body>

</html>
