<div>
    <div class="flex md:flex-row flex-col justify-between md:items-center gap-2 mt-1 mb-3 md:pl-3 w-full">
        <div class="font-[700] text-slate-500">All registered user dashboards are logged here (Lookup users dashboard information by providing the user's name).</div>
        <div id="search-bar" class="md:ml-3">
            <div class="relative w-full min-w-[200px] max-w-sm">
                {{-- <form wire:submit.prevent="search" class="relative"> --}}
                <form  class="relative">
                    <input wire:model.live.debounce.400ms="name"
                        class="bg-transparent bg-white shadow-sm focus:shadow-md py-2 pr-11 pl-3 border border-slate-300 hover:border-slate-400 focus:border-slate-400 rounded focus:outline-none w-full h-10 text-slate-700 placeholder:text-slate-400 text-sm transition duration-300 ease"
                        placeholder="John Doe..." />
                    {{-- <button type="submit" class="top-1 right-1 absolute flex items-center bg-white my-auto px-2 rounded w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button> --}}
                </form>
            </div>
        </div>
    </div>

    <div class="relative flex flex-col bg-white bg-clip-border shadow-md rounded-lg w-full h-full overflow-scroll text-gray-700">
        <table class="w-full min-w-max text-left table-auto">
            <thead class="bg-[#51504f] font-semibold text-white text-sm text-left">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Customer Name</th>
                    <th class="px-6 py-3">Wallet Balance</th>
                    <th class="px-6 py-3">Dashboard Status</th>
                    <th class="px-6 py-3">Action</th>
                    {{-- <th class="px-6 py-3">Payment Method</th>
                    <th class="px-6 py-3">Payment Type</th>
                    <th class="px-6 py-3">Payment Date</th>
                    <th class="px-6 py-3">Payment Status</th>
                    <th class="px-6 py-3">Payment Proof</th>
                    <th class="px-6 py-3">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($users->isNotEmpty())
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 py-5 border-slate-200 border-b">{{$user->id}}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{$user->name}}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">NGN {{ $user->activeDashboard ? number_format($user->activeDashboard->wallet_balance, 2) : "0.00"}}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{$user->activeDashboard ? "Active" : "Inactive"}}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">
                                {{-- <a class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200" href="{{ route('platform.manage.user-dashboard', ['id' => $payment->id]) }}"> --}}
                                {{-- <a class="bg-[#51504F] hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200" href="{{ route('platform.manage.user-dashboard', ['id' => $user->activeDashboard->id ]) }}">
                                    view more <span class="mdi mdi-open-in-new"></span>
                                </a> --}}
                                @if ($user->activeDashboard)
                                <a class="bg-[#51504F] hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200"
                                   href="{{ route('platform.manage.user-dashboard', ['id' => $user->activeDashboard->id]) }}">
                                   view more <span class="mdi mdi-open-in-new"></span>
                                </a>
                            @else
                                <span>No active dashboard available</span>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="p-4 text-center">User Not found :(<br>
                     <button class="underline"  onclick="window.location.reload();" >reload page <span class="mdi mdi-reload"></span></button> </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
