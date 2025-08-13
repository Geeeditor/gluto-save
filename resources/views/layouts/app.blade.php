<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

        <title>  @yield('title') | {{config('app.name')}}</title>
        {{-- <link rel="canonical" href="{{ env('APP_URL') }}"> --}}
        {{-- {{env('APP_NAME')}} --}}
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <script src="//unpkg.com/alpinejs" defer></script>
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
            <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
            <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/media.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/remixicon.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper.min.css') }}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/aos.css') }}">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
            <script src="{{ asset('js/swiper.min.js') }}"></script>
            <script src="{{ asset('js/aos.js') }}"></script>
            <script src="{{ asset('js/script.js') }}" defer></script>
            <script src="{{ asset('js/bodymovin.js') }}"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.13.0/lottie.min.js" integrity="sha512-uOtp2vx2X/5+tLBEf5UoQyqwAkFZJBM5XwGa7BfXDnWR+wdpRvlSVzaIVcRe3tGNsStu6UMDCeXKEnr4IBT8gA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <meta name="description" content="@yield('description')">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div
        class="hidden right-0 bottom-3 z-[600] fixed space-y-6 mx-auto mt-4 w-3/4 md:w-2/5 flash-message tray-success animate__animated">

        @if (session()->has('success'))
            <div class="flex items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
                role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline fill-green-600 mr-3 w-[18px] shrink-0"
                    viewBox="0 0 512 512">
                    <ellipse cx="246" cy="246" data-original="#000" rx="246" ry="246" />
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
                    <ellipse cx="246" cy="246" data-original="#000" rx="246" ry="246" />
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
            <div class="flex items-center bg-white shadow-[0_3px_10px_-3px_rgba(6,81,237,0.3)] p-4 rounded-md text-slate-900"
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









    </div>
    <script>
        function showFlashMessage() {
            const flashMessage = document.querySelector('.flash-message');
            flashMessage.style.display = 'block'; // Show the message
            flashMessage.classList.add('animate__fadeInRight'); // Add animation class

            // Optionally, hide the message after a few seconds
            setTimeout(() => {
                // flashMessage.classList.remove('animate__backInRight'); // Add animation
                flashMessage.classList.add('animate__fadeOutRight'); // Add animation
                flashMessage.style.display = 'none'; // Hide the message after 3 seconds
            }, 5000);
        }

        window.onload = function() {
            // const preloader = document.getElementById('preloader');
            // preloader.style.opacity = '0'; // Start fading out
            // setTimeout(() => {
            //     preloader.style.display = 'none'; // Hide after fade out
            // }, 1000); // Duration should match the CSS transition

            showFlashMessage()
        };
    </script>

        <header class="d-flex header align-center space-between">
            <a href="index">
                <img class="header-logo" src="{{asset('images/logo.png')}}">
            </a>

            <div class="navigation-wrapper">
                <img src="{{asset('images/bar.png')}}" class="nav-toggle toggle-open">
                <div class="d-flex navigation-menu align-center">
                    <div class="d-flex space-between mobile-logo align-center">
                        <img class="header-logo" src="{{asset('images/logo.png')}}">
                        <img src="{{asset('images/times.png')}}" class="toggle-close">
                    </div>
                    <nav class="d-flex navigation">
                        <a class="{{ Request::routeIs('index') ? 'nav-link-active' : '' }} nav-link  " href="{{route('index')}}">Home</a>
                        <a class="{{ Request::routeIs('about') ? 'nav-link-active' : '' }} nav-link" href="{{route('about')}}">About Us</a>
                        <a class="{{ Request::routeIs('how') ? 'nav-link-active' : '' }} nav-link" href="{{route('how')}}">How it Works</a>
                        <!-- 		<a class="nav-link" href="gallery">Gallery</a> -->
                        <a class="{{ Request::routeIs('faq') ? 'nav-link-active' : '' }} nav-link" href="{{route('faq')}}">FAQ</a>
                        <a class="{{ Request::routeIs('contact') ? 'nav-link-active' : '' }} nav-link" href="{{route('contact')}}">Contact</a>
                    </nav>
                    <div class="d-flex nav-buttons">
                        @guest
                          <a class="nav-btn" href="{{route('login')}}">Login</a>
                          <a class="nav-btn" href="{{route('register')}}">Sign Up</a>
                        @endguest

                        @auth

                        <a class="nav-btn" href="{{route('dashboard')}}">Go To Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}" class="nav-btn">
                            @csrf
                            <button type="submit"  class="d-flex sidebar-navigation-list spacing align-center">
                                <img src="{{ asset('assets/images/logout.png') }}">
                                <span class="btn-text">Logout</span>
                            </button>
                        </form>

                        @endauth


                    </div>
                </div>

            </div>

        </header>
            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            	<!-- FOOTER STARTS -->
	<footer class="d-flex footer">
		<div class="footer-list">
			<img class="max-w-[150px] footer-img" src="{{asset('images/logo-stroke.png')}}">


		</div>

		<div class="footer-list">
			<h3 class="footer-heading">Legal</h3>
			<div class="d-flex flex-col footer-link">
				<a href="{{route('terms')}}">Terms</a>
			</div>
		</div>

		<div class="footer-list">
			<h3 class="footer-heading">Company</h3>
			<div class="d-flex flex-col footer-link">
				<a href="{{route('about')}}">About</a>
				<a href="{{route('faq')}}">FAQs</a>
			</div>
		</div>

		<div class="footer-list">

			<div class="d-flex footer-icon-list">
				<a href="javascript:void()" class="footer-icon"><i class="ri-instagram-line"></i></a>
				<a href="javascript:void()" class="footer-icon"><i class="ri-linkedin-fill"></i></a>
				<a href="javascript:void()" class="footer-icon"><i class="ri-facebook-line"></i></a>
				<a href="javascript:void()" class="footer-icon"><i class="ri-twitter-fill"></i></a>
				<a href="javascript:void()" class="footer-icon"><i class="ri-youtube-fill"></i></a>
			</div>
			<div class="d-flex flex-col footer-text">
				<p>10, Bristol Road, GRA, Apapa, Lagos State, Nigeria .</p>
				<p>info@glutointernational.com</p>
				<p><a href="tel:+2347025060073">+234 80 867 782 87</a></p>


			</div>


		</div>

	</footer>

            <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>

    </body>
</html>
