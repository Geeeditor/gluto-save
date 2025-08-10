{{-- @livewire('withdrawal-table') --}}

@section('content')
    <section>




        @livewire('chart')


        <div class="flex flex-wrap justify-between items-stretch gap-4 w-full">


            <div
                class="flex items-center gap-3 bg-white hover:bg-gray-100 shadow-sm p-6 border border-gray-200 rounded-lg basis-full md:basis-[48%]">

                <span class="text-[70px] mdi mdi-cash-register"></span>

                <div class="flex flex-col items-start">
                    <h5 class="text-gray-900 text-2xl text-start tracking-tight poppins-semibold">PAYMENTS PROCESSED</h5>
                    <p class="text-gray-600 text-3xl text-start libertinus-sans-regular">{{$paymentProcessed}}</p>
                </div>
            </div>

            <div
                class="flex items-center gap-3 bg-white hover:bg-gray-100 shadow-sm p-6 border border-gray-200 rounded-lg basis-full md:basis-[48%]">

                <span class="text-[70px] mdi mdi-account-plus mdi"></span>

                <div class="flex flex-col items-start">
                    <h5 class="text-gray-900 text-2xl text-start tracking-tight poppins-semibold">REGISTERED USERS</h5>
                    <p class="text-gray-600 text-3xl text-start libertinus-sans-regular">{{$users}}</p>
                </div>
            </div>


            <div
                class="flex items-center gap-3 bg-white hover:bg-gray-100 shadow-sm p-6 border border-gray-200 rounded-lg basis-full md:basis-[48%]">

                <span class="text-[70px] mdi mdi-account-credit-card mdi"></span>

                <div class="flex flex-col items-start">
                    <h5 class="text-gray-900 text-2xl text-start tracking-tight poppins-semibold">ACTIVE DASHBOARDS</h5>
                    <p class="text-gray-600 text-3xl text-start libertinus-sans-regular">{{$dashboards}}</p>
                </div>
            </div>

            <div
                class="flex items-center gap-3 bg-white hover:bg-gray-100 shadow-sm p-6 border border-gray-200 rounded-lg basis-full md:basis-[48%]">

                <span class="mdi-account-credit-card-outline text-[70px] mdi mdi"></span>

                <div class="flex flex-col items-start">
                    <h5 class="text-gray-900 text-2xl text-start tracking-tight poppins-semibold">ACTIVE SUBSCRIPTION </h5>
                    <p class="text-gray-600 text-3xl text-start libertinus-sans-regular">100</p>
                </div>
            </div>

        </div>







    </section>
@endsection
