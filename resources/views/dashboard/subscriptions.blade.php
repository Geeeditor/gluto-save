@extends('layouts.auth')
@section('title', 'Subscriptions')
@section('content')



    <h1 class="mb-3 font-bold text-2xl tracking-wide">My Subscription Plan</h1>

    @if ($subscriptions->isEmpty())
        <div class="alert alert-warning">
            <strong>No subscriptions found.</strong> Please select a plan to get started.
            <h3>Note: Each Plan Spans A Duration Of 52 Weeks</h3>

        </div>

        <div class="mx-auto md:mx-none py-7">
            <div class="relative flex md:flex-row flex-col justify-center md:justify-between items-center gap-8">
                <!-- Red wavy line behind cards -->
                <svg class="hidden md:block top-1/2 right-0 left-0 -z-10 absolute" fill="none"
                    style="height: 120px; width: 100%;" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 160C80 120 160 80 240 96C320 112 400 176 480 176C560 176 640 112 720 96C800 80 880 112 960 128C1040 144 1120 144 1200 128C1280 112 1360 80 1440 96"
                        stroke="#B91C1C" stroke-width="2" />
                </svg>
                <!-- Card 1 -->
                <div
                    class="relative flex flex-col items-center bg-green-700 px-6 pt-10 pb-6 rounded-md w-72 text-center hover:scale-[1.02] transition-transform duration-300">
                    <div class="-top-6 absolute bg-green-600 px-4 py-2 rounded-md font-bold text-white text-sm">
                        SAVINGS
                    </div>
                    <img src="{{ asset('images/savings.svg') }}"
                        alt="Illustration of a woman with afro hairstyle wearing a yellow dress standing next to a green plant in a yellow pot"
                        class="mb-6 h-[160px]" />
                    <p class="mb-2 text-white text-sm italic-font leading-tight">
                        Get Started With Our SAVINGS Contribution Package That Spans Over 52wks
                        With A Weekly Payment Of
                    </p>
                    <p class="mb-4 font-semibold text-white text-lg">₦ 1,300</p>
                    <div class="bg-green-600 mb-6 px-3 py-2 rounded-md text-white text-xs">
                        NB: IF YOU UPLOAD A FAKE PAYMENT PROOF, YOUR ACCOUNT WOULD BE FLAGGED
                        AND YOUR PROFILE TERMINATED.
                    </div>
                    <form action="{{ route('plan.store', ['plan' => 'savings']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="savings">
                        <input type="number" name="amount" value="1300.00" hidden>

                        <button
                            class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-md text-white text-sm transition">
                            CONTINUE
                        </button>
                    </form>
                </div>
                <!-- Card 2 -->
                <div
                    class="relative flex flex-col items-center bg-green-700 px-6 pt-10 pb-6 rounded-md w-72 text-center hover:scale-[1.02] transition-transform duration-300">
                    <div class="-top-6 absolute bg-green-600 px-4 py-2 rounded-md font-bold text-white text-sm">
                        PRO
                    </div>
                    <img src="{{ asset('images/pro.svg') }}"
                        alt="Illustration of a man and woman both wearing yellow outfits standing side by side"
                        class="mb-6" width="150" height="150" />
                    <p class="mb-2 text-white text-sm italic-font leading-tight">
                        Get Started With Our PRO Contribution Package That Spans Over 52wks
                        With A Weekly Payment Of
                    </p>
                    <p class="mb-4 font-semibold text-white text-lg">₦ 2,000</p>
                    <div class="bg-green-600 mb-6 px-3 py-2 rounded-md text-white text-xs">
                        NB: IF YOU UPLOAD A FAKE PAYMENT PROOF, YOUR ACCOUNT WOULD BE FLAGGED
                        AND YOUR PROFILE TERMINATED.
                    </div>
                    <form action="{{ route('plan.store', ['plan' => 'pro']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="pro">
                        <input type="number" name="amount" value="2000.00" hidden>

                        <button
                            class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-md text-white text-sm transition">
                            CONTINUE
                        </button>
                    </form>
                </div>
                <!-- Card 3 -->
                <div
                    class="relative flex flex-col items-center bg-green-700 px-6 pt-10 pb-6 rounded-md w-72 text-center hover:scale-[1.02] transition-transform duration-300">
                    <div class="-top-6 absolute bg-green-600 px-4 py-2 rounded-md font-bold text-white text-sm">
                        BOSS
                    </div>
                    <img src="{{ asset('images/boss.svg') }}"
                        alt="Illustration of two women standing next to large green plants in pots, one woman wearing a green dress and the other a yellow dress"
                        class="mb-6" width="150" height="150" />
                    <p class="mb-2 text-white text-sm italic-font leading-tight">
                        Get Started With Our BOSS Contribution Package That Spans Over 52wks
                        With A Weekly Payment Of
                    </p>
                    <p class="mb-4 font-semibold text-white text-lg">₦ 5,000</p>
                    <div class="bg-green-600 mb-6 px-3 py-2 rounded-md text-white text-xs">
                        NB: IF YOU UPLOAD A FAKE PAYMENT PROOF, YOUR ACCOUNT WOULD BE FLAGGED
                        AND YOUR PROFILE TERMINATED.
                    </div>
                    <form action="{{ route('plan.store', ['plan' => 'boss']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="boss">
                        <input type="number" name="amount" value="5000.00" hidden>

                        <button
                            class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-md text-white text-sm transition">
                            CONTINUE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <section x-data="{ addplan: false }">
            <main class="flex-1 bg-gray-100 overflow-x-hidden overflow-y-auto">
                <div class="mx-auto px-4 sm:px-6 py-8 container">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="font-bold text-gray-800 text-2xl">My Plans</h1>
                        <a href="#addplan"
                            @click.prevent="addplan = !addplan; $nextTick(() => {
                            const element = document.getElementById('addplan');
                            if (element) {
                                element.scrollIntoView({ behavior: 'smooth' });
                            }
                        })"
                            class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600 shadow px-4 py-2 rounded-lg text-white">
                            <span>Add New Plan</span> <span :class="addplan ? 'mdi-close-circle-multiple' : 'mdi-plus'"
                                class="mdi"></span>
                        </a>
                    </div>

                    <div class="mb-8">
                        <div class="flex justify-between gap-2">
                            <h2 class="mb-4 font-semibold text-gray-700 text-xl">Current Subscription Plan</h2>

                            <p class="text-sm text-right"> <span class="font-bold">Sub ID</span>
                                <br> {{ $currentSubscription->sub_id }}
                            </p>

                        </div>
                        @if ($currentSubscription)
                            <div class="bg-white shadow-md p-6 rounded-lg">
                                <div class="flex md:flex-row flex-col justify-between items-start md:items-center">
                                    <div class="">
                                        <h3 class="flex items-center gap-1 font-bold text-gray-700 text-lg capitalize">
                                            {{ $currentSubscription->tier }} <span
                                                class="font-[200] text-[10px] text-gray-500">(₦{{ number_format($currentSubscription->sub_fee, 2) }}
                                                wkly)</span></h3>
                                        <p class="text-gray-500">Subscribed on:
                                            {{ $currentSubscription->created_at->format('d M, Y') }}</p>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        @php
                                            $statusMapping = [
                                                'active' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-800',
                                                    'label' => 'Active',
                                                ],
                                                'pending_activation' => [
                                                    'bg' => 'bg-yellow-100',
                                                    'text' => 'text-yellow-800',
                                                    'label' => 'Pending Activation',
                                                ],
                                                'inactive' => [
                                                    'bg' => 'bg-gray-100',
                                                    'text' => 'text-gray-800',
                                                    'label' => 'Inactive',
                                                ],
                                                'terminated' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-800',
                                                    'label' => 'Terminated',
                                                ],
                                                'matured' => [
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-800',
                                                    'label' => 'Matured',
                                                ],
                                            ];

                                            $currentStatus = $statusMapping[$currentSubscription->package_status] ?? [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-800',
                                                'label' => 'Unknown',
                                            ];
                                        @endphp

                                        <span
                                            class="{{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} mr-2 px-2.5 py-0.5 rounded-full font-medium text-sm">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-6 pt-4 border-t">
                                    <div class="gap-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 text-center">

                                        <div>
                                            <p class="text-gray-500 text-sm">Total Contribution</p>
                                            <p class="font-semibold text-gray-800 text-lg">
                                                ₦{{ number_format($currentSubscription->total_contribution, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Defaulted Weeks</p>
                                            <p class="font-semibold text-gray-800 text-lg">
                                                {{ $currentSubscription->defaulted_weeks }} Weeks</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Duration</p>
                                            <p class="font-semibold text-gray-800 text-lg"> 52 Weeks</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Next Contribution</p>
                                            <p class="font-semibold text-gray-800 text-lg">
                                                {{ \Carbon\Carbon::now()->next(\Carbon\Carbon::FRIDAY)->format('d M, Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Maturity Date</p>
                                            <p class="font-semibold text-gray-800 text-lg">
                                                {{ $currentSubscription->created_at->addWeeks(52)->format('d M, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="bg-gray-200 rounded-full w-full h-2.5">
                                        <div class="bg-orange-500 rounded-full h-2.5"
                                            style="width: {{ $currentSubscription->total_contribution / ($currentSubscription->sub_fee * 52) * 100 }}%">
                                        </div>
                                        {{-- sub_fee * 52 / total_contribution --}}
                                        {{-- (total_contribution / sub_fee * 52 ) * 100 --}}
                                    </div>
                                    <p class="mt-1 text-gray-500 text-sm">{{ $currentSubscription->total_contribution / $currentSubscription->sub_fee }} / 52
                                        weeks completed</p>
                                </div>

                            </div>
                        @else
                            <p class="text-gray-500">No active plans found.</p>
                        @endif
                    </div>

                    <div>
                        <h2 class="mb-4 font-semibold text-gray-700 text-xl">All Subscribed Plans</h2>
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-gray-500 text-sm text-left">
                                    <thead class="bg-gray-50 text-gray-700 text-xs uppercase">
                                        <tr>
                                            <th class="px-6 py-3" scope="col">Plan Name</th>
                                            <th class="px-6 py-3" scope="col">Weekly Payment</th>
                                            <th class="px-6 py-3" scope="col">Subscribed Date</th>
                                            <th class="px-6 py-3" scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $subscription)
                                            @php
                                                $statusMapping = [
                                                    'active' => [
                                                        'bg' => 'bg-green-100',
                                                        'text' => 'text-green-800',
                                                        'label' => 'Active',
                                                    ],
                                                    'pending_activation' => [
                                                        'bg' => 'bg-yellow-100',
                                                        'text' => 'text-yellow-800',
                                                        'label' => 'Pending Activation',
                                                    ],
                                                    'inactive' => [
                                                        'bg' => 'bg-gray-100',
                                                        'text' => 'text-gray-800',
                                                        'label' => 'Inactive',
                                                    ],
                                                    'terminated' => [
                                                        'bg' => 'bg-red-100',
                                                        'text' => 'text-red-800',
                                                        'label' => 'Terminated',
                                                    ],
                                                    'matured' => [
                                                        'bg' => 'bg-blue-100',
                                                        'text' => 'text-blue-800',
                                                        'label' => 'Matured',
                                                    ],
                                                ];

                                                $currentStatus = $statusMapping[$subscription->package_status] ?? [
                                                    'bg' => 'bg-gray-100',
                                                    'text' => 'text-gray-800',
                                                    'label' => 'Unknown',
                                                ];
                                            @endphp
                                            <tr class="bg-white border-b">
                                                <th class="px-6 py-4 font-medium text-gray-900 uppercase whitespace-nowrap"
                                                    scope="row">
                                                    {{ $subscription->tier }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    ₦{{ number_format($subscription->sub_fee, 2) }}</td>
                                                <td class="px-6 py-4">{{ $subscription->created_at->format('d M, Y') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span
                                                        class="{{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} mr-2 px-2.5 py-0.5 rounded-full font-medium text-xs">
                                                        {{ $currentStatus['label'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            {{-- <div class="alert alert-info">
            <strong>Current Subscriptions: {{$currentSubscription->sub_id}}</strong>
            <ul>
                @foreach ($subscriptions as $subscription)
                    <li>
                        <strong>{{ $subscription->tier }}</strong> - ₦{{ number_format($subscription->amount, 2) }}
                        <span class="text-muted">({{ $subscription->created_at->diffForHumans() }})</span>
                    </li>
                @endforeach
            </ul>
        </div> --}}

            <div x-show="addplan" x-transition:enter.duration.500ms x-transition:enter.scale.origin.right
                x-transition:leave.duration.400ms x-transition:leave.scale.origin.right id="addplan"
                :class="addplan ? 'block' : 'hidden'" class="mx-auto md:mx-none py-7">
                <div class="relative flex md:flex-row flex-col justify-center md:justify-between items-center gap-8">
                    <!-- Red wavy line behind cards -->
                    <svg class="hidden md:block top-1/2 right-0 left-0 -z-10 absolute" fill="none"
                        style="height: 120px; width: 100%;" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0 160C80 120 160 80 240 96C320 112 400 176 480 176C560 176 640 112 720 96C800 80 880 112 960 128C1040 144 1120 144 1200 128C1280 112 1360 80 1440 96"
                            stroke="#B91C1C" stroke-width="2" />
                    </svg>
                    <!-- Card 1 -->
                    <div
                        class="relative flex flex-col items-center bg-green-700 px-6 pt-10 pb-6 rounded-md w-72 text-center hover:scale-[1.02] transition-transform duration-300">
                        <div class="-top-6 absolute bg-green-600 px-4 py-2 rounded-md font-bold text-white text-sm">
                            SAVINGS
                        </div>
                        <img src="{{ asset('images/savings.svg') }}"
                            alt="Illustration of a woman with afro hairstyle wearing a yellow dress standing next to a green plant in a yellow pot"
                            class="mb-6 h-[160px]" />
                        <p class="mb-2 text-white text-sm italic-font leading-tight">
                            Get Started With Our SAVINGS Contribution Package That Spans Over 52wks
                            With A Weekly Payment Of
                        </p>
                        <p class="mb-4 font-semibold text-white text-lg">₦ 1,300</p>
                        <div class="bg-green-600 mb-6 px-3 py-2 rounded-md text-white text-xs">
                            NB: IF YOU UPLOAD A FAKE PAYMENT PROOF, YOUR ACCOUNT WOULD BE FLAGGED
                            AND YOUR PROFILE TERMINATED.
                        </div>
                        <form action="{{ route('plan.store', ['plan' => 'savings']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="savings">
                            <input type="number" name="amount" value="1300.00" hidden>

                            <button
                                class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-md text-white text-sm transition">
                                CONTINUE
                            </button>
                        </form>
                    </div>
                    <!-- Card 2 -->
                    <div
                        class="relative flex flex-col items-center bg-green-700 px-6 pt-10 pb-6 rounded-md w-72 text-center hover:scale-[1.02] transition-transform duration-300">
                        <div class="-top-6 absolute bg-green-600 px-4 py-2 rounded-md font-bold text-white text-sm">
                            PRO
                        </div>
                        <img src="{{ asset('images/pro.svg') }}"
                            alt="Illustration of a man and woman both wearing yellow outfits standing side by side"
                            class="mb-6" width="150" height="150" />
                        <p class="mb-2 text-white text-sm italic-font leading-tight">
                            Get Started With Our PRO Contribution Package That Spans Over 52wks
                            With A Weekly Payment Of
                        </p>
                        <p class="mb-4 font-semibold text-white text-lg">₦ 2,000</p>
                        <div class="bg-green-600 mb-6 px-3 py-2 rounded-md text-white text-xs">
                            NB: IF YOU UPLOAD A FAKE PAYMENT PROOF, YOUR ACCOUNT WOULD BE FLAGGED
                            AND YOUR PROFILE TERMINATED.
                        </div>
                        <form action="{{ route('plan.store', ['plan' => 'pro']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="pro">
                            <input type="number" name="amount" value="2000.00" hidden>

                            <button
                                class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-md text-white text-sm transition">
                                CONTINUE
                            </button>
                        </form>
                    </div>
                    <!-- Card 3 -->
                    <div
                        class="relative flex flex-col items-center bg-green-700 px-6 pt-10 pb-6 rounded-md w-72 text-center hover:scale-[1.02] transition-transform duration-300">
                        <div class="-top-6 absolute bg-green-600 px-4 py-2 rounded-md font-bold text-white text-sm">
                            BOSS
                        </div>
                        <img src="{{ asset('images/boss.svg') }}"
                            alt="Illustration of two women standing next to large green plants in pots, one woman wearing a green dress and the other a yellow dress"
                            class="mb-6" width="150" height="150" />
                        <p class="mb-2 text-white text-sm italic-font leading-tight">
                            Get Started With Our BOSS Contribution Package That Spans Over 52wks
                            With A Weekly Payment Of
                        </p>
                        <p class="mb-4 font-semibold text-white text-lg">₦ 5,000</p>
                        <div class="bg-green-600 mb-6 px-3 py-2 rounded-md text-white text-xs">
                            NB: IF YOU UPLOAD A FAKE PAYMENT PROOF, YOUR ACCOUNT WOULD BE FLAGGED
                            AND YOUR PROFILE TERMINATED.
                        </div>
                        <form action="{{ route('plan.store', ['plan' => 'boss']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="boss">
                            <input type="number" name="amount" value="5000.00" hidden>

                            <button
                                class="bg-orange-600 hover:bg-orange-700 px-5 py-2 rounded-md text-white text-sm transition">
                                CONTINUE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    @endif


@endsection
