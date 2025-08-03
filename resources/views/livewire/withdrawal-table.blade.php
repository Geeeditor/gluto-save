<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/light-font@0.2.63/css/materialdesignicons-light.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @if (session()->has('message'))
        <div class="text-red-500">{{ session('message') }}</div>
    @endif

    <div class="flex md:flex-row flex-col justify-between md:items-center gap-2 mt-1 mb-3 md:pl-3 w-full">
        <div class="font-[700] text-slate-500">All user withdrawal can be found here .</div>
        <div id="search-bar" class="md:ml-3">
            <div class="relative w-full min-w-[200px] max-w-sm">
                {{-- <form wire:submit.prevent="search" class="relative"> --}}
                <form  class="relative">
                    <input wire:model.live.debounce.400ms="trxRef"
                        class="bg-transparent bg-white shadow-sm focus:shadow-md py-2 pr-11 pl-3 border border-slate-200 hover:border-slate-400 focus:border-slate-400 rounded focus:outline-none w-full h-10 text-slate-700 placeholder:text-slate-400 text-sm transition duration-300 ease"
                        placeholder="ghep/debit/DM..." />
                    {{-- <button type="submit" class="top-1 right-1 absolute flex items-center bg-white my-auto px-2 rounded w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button> --}}
                </form>
            </div>
        </div>
    </div>

    {{-- Main content here  --}}
    <div class="relative flex flex-col bg-white bg-clip-border shadow-md rounded-lg w-full h-full overflow-scroll text-gray-700">

    <table class="w-full min-w-max text-left table-auto">
        <thead class="bg-[#51504f] font-semibold text-white text-sm text-left">
            <tr>
                <th class="px-6 py-3">Customer Name</th>
                <th class="px-6 py-3">Name/Crypto Option</th>
                <th class="px-6 py-3">Details</th>
                <th class="px-6 py-3">Amount</th>
                <th class="px-6 py-3">Date</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm">
            @if ($withdrawals->isNotEmpty())
            @foreach ($withdrawals as $withdrawal)
                <tr class="relative hover:bg-gray-50 border-b cursor-pointer">
                    <td class="px-6 py-4 font-medium capitalize">
                        {{ $withdrawal->user->name }}</td>
                    <td class="px-6 py-4 font-medium capitalize">
                        {{ $withdrawal->account_name ?: $withdrawal->crypto_option }}</td>
                    <td class="px-6 py-4">
                        @if ($withdrawal->wallet_address)
                            <div class="truncate">
                                <strong>Wallet Address:</strong> {{ $withdrawal->wallet_address }}<br>
                                <strong>Network:</strong> {{ $withdrawal->network }}
                                <br>
                                <strong>Transaction Reference:</strong> {{ $withdrawal->transaction_reference }}
                                <br>
                                <strong>Withdrawal Date:</strong> {{ $withdrawal->created_at->format('F j, Y') }}
                            </div>
                        @else
                            <div>
                                <strong>Account Number:</strong> {{ $withdrawal->account_number }}<br>
                                <strong>Bank Name:</strong> {{ $withdrawal->bank_name }}
                                <br>
                                <strong>Transaction Reference:</strong> {{ $withdrawal->transaction_reference }}
                                <br>
                                <strong>Withdrawal Date:</strong> {{ $withdrawal->created_at->format('F j, Y') }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $withdrawal->account_name ? "NGN ".  number_format($withdrawal->amount, 2 ) : "USD ".  number_format($withdrawal->amount, 2 ) }}</td>
                    <td class="px-6 py-4">{{ $withdrawal->created_at->format('F j, Y')  }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="{{$withdrawal->withdrawal_status == 'pending' ? 'inline-block bg-yellow-100 px-3 py-1 rounded-full font-semibold text-yellow-800 text-xs' : ($withdrawal->withdrawal_status == 'failed' ? 'inline-block bg-red-100 px-3 py-1 rounded-full font-semibold text-red-800 text-xs' : 'inline-block bg-green-100 px-3 py-1 rounded-full font-semibold text-green-800 text-xs') }}">
                            {!! $withdrawal->withdrawal_status == 'pending' || $withdrawal->withdrawal_status == 'approved' ? ucfirst($withdrawal->withdrawal_status) : 'Failed' !!}
                        </span>
                    </td>

                    <td class="p-4 py-5 border-slate-200 border-b">
                        <a class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200" href="{{ route('platform.withdrawal.update', ['id' => $withdrawal->id]) }}">
                            view more <span class="mdi mdi-open-in-new"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            @else
                    <tr>
                        <td colspan="10" class="p-4 text-center">No transaction found :(<br>
                     <button class="underline"  onclick="window.location.reload();" >reload page <span class="mdi mdi-reload"></span></button> </td>
                    </tr>
                @endif
        </tbody>
    </table>
    </div>

</div>
