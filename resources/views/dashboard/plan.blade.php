@extends('layouts.app')
@section('title', 'Subscribe To A Plan')
@section('description', 'Gluto HEP: Select a Plan')
@section('content')
<div class="container signup">
    <div class="top-desc">
        <h1 class="top-title">Hello {{$user->name}}</h1>
        <h3 class="top-title">Please Pick Contribution Plan</h3>
    </div>

    <div class="grid-lists vision-grid-list" style="align-items: stretch;" data-aos="slide-up">
        <div class="col-3 signup-col bg1" data-attr="SAVINGS">
            <p class="text-md">
                <img class="mx-auto" src="{{asset('./images/savings.svg')}}" alt="Savings">
                <span class="block mb-3 text-center capitalize oleo-script-regular">
                   Get started with our SAVINGS contribution package that spans over 52wks with a weekly payment of <span class="block text-xl">₦ 1,300</span>
                </span>
                <!-- <br><br> <span style="color: red; font-weight: bold;">NB: </span> -->
                <div class="bg-[#1aab26] mb-4 px-1 py-2 rounded-sm">
                    <span style="color: white;  font-weight: bold;" class="block text-sm text-center">NB: IF YOU UPLOAD A FAKE PAYMENT
                        PROOF,
                        YOUR ACCOUNT WOULD BE FLAGGED AND YOUR PROFILE TERMINATED.
                    </span>
                </div>
                <form method="post"  action="">
                    @csrf
                    <input type="text" name="plan" value="savings" hidden>
                    <input type="number" name="amount" value="1300.00" hidden>
                    <button type="submit" class="bg-[#cf6720] hover:bg-[#914e21] mx-auto px-2 py-3 rounded-md text-white">
                        CONTINUE
                    </button>

                </form>
            </p>
        </div>
        <div class="col-3 signup-col bg1" data-attr="PRO">
            <p class="text-md">
                <img class="mx-auto" src="{{asset('./images/pro.svg')}}" alt="Savings">
                <span class="block mb-3 text-center capitalize oleo-script-regular">
                   Get started with our PRO contribution package that spans over 52wks with a weekly payment of <span class="block text-xl">₦ 2,000</span>
                </span>
                <!-- <br><br> <span style="color: red; font-weight: bold;">NB: </span> -->
                <div class="bg-[#1aab26] mb-4 px-1 py-2 rounded-sm">
                    <span style="color: white;  font-weight: bold;" class="block text-sm text-center">NB: IF YOU UPLOAD A FAKE PAYMENT
                        PROOF,
                        YOUR ACCOUNT WOULD BE FLAGGED AND YOUR PROFILE TERMINATED.
                    </span>
                </div>
                <form  method="post"  action="">
                    @csrf
                    <input type="text" name="plan" value="pro" hidden>
                    <input type="number" name="amount" value="2000.00" hidden>

                    <button type="submit" class="bg-[#cf6720] hover:bg-[#914e21] mx-auto px-2 py-3 rounded-md text-white">
                        CONTINUE
                    </button>

                </form>
            </p>
        </div>
        <div class="col-3 signup-col bg1" data-attr="BOSS">
            <p class="text-md">
                <img class="mx-auto" src="{{asset('./images/boss.svg')}}" alt="Savings">
                <span class="block mb-3 text-center capitalize oleo-script-regular">
                   Get started with our BOSS contribution package that spans over 52wks with a weekly payment of <span class="block text-xl">₦ 5,000</span>
                </span>
                <!-- <br><br> <span style="color: red; font-weight: bold;">NB: </span> -->
                <div class="bg-[#1aab26] mb-4 px-1 py-2 rounded-sm">
                    <span style="color: white;  font-weight: bold;" class="block text-sm text-center">NB: IF YOU UPLOAD A FAKE PAYMENT
                        PROOF,
                        YOUR ACCOUNT WOULD BE FLAGGED AND YOUR PROFILE TERMINATED.
                    </span>
                </div>
                <form  method="post"  action="">
                    @csrf
                    <input type="text" name="plan" value="boss" hidden>
                    <input type="number" name="amount" value="5000.00" hidden>

                    <button type="submit" class="bg-[#cf6720] hover:bg-[#914e21] mx-auto px-2 py-3 rounded-md text-white">
                        CONTINUE
                    </button>

                </form>
            </p>
        </div>
    </div>
</div>
@endsection
