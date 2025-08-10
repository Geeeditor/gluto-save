<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/light-font@0.2.63/css/materialdesignicons-light.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @if (session()->has('message'))
        <div class="text-red-500">{{ session('message') }}</div>
    @endif

    <div class="flex md:flex-row flex-col justify-between md:items-center gap-2 mt-1 mb-3 md:pl-3 w-full">
        <div class="font-[700] text-slate-500">All user payments can be found here (registration, contribution, debt payment and subscription).</div>
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

    <div class="relative flex flex-col bg-white bg-clip-border shadow-md rounded-lg w-full h-full overflow-scroll text-gray-700">
        <table class="w-full min-w-max text-left table-auto">
            <thead class="bg-[#51504f] font-semibold text-white text-sm text-left">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Customer's Name</th>
                    <th class="px-6 py-3">Amount</th>
                    <th class="px-6 py-3">Trx Ref</th>
                    <th class="px-6 py-3">Payment Method</th>
                    <th class="px-6 py-3">Payment Type</th>
                    <th class="px-6 py-3">Payment Date</th>
                    <th class="px-6 py-3">Payment Status</th>
                    <th class="px-6 py-3">Payment Proof</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($paymentData->isNotEmpty())
                    @foreach ($paymentData as $payment)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 py-5 border-slate-200 border-b">{{ $payment->id }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{ $payment->user->name }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">NGN {{ number_format($payment->amount) }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{ $payment->transaction_reference }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b capitalize">
                                {{ $payment->payment_method == 'gluto_transfer' ? 'Bank Transfer' : ($payment->payment_method == 'wallet_balance' ? 'Wallet Balance' : ($payment->payment_method == 'paystack' ? 'Paystack' : $payment->payment_method)) }}
                                {{-- {{ $payment->payment_method }} --}}
                            </td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{ $payment->payment_type == 'registration' ? 'Registration' : ($payment->payment_type == 'wallet_fund' ? 'Wallet Funding' : ($payment->payment_type == 'contribution' ? 'Contribution' : ($payment->payment_type == 'debt_pyt' ? 'Debt Payment' : ($payment->payment_type == 'subscription' ? 'Subscription' : 'Unknown')))) }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{ $payment->created_at->format('F j, Y') }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">{{ $payment->payment_status }}</td>
                            <td class="p-4 py-5 border-slate-200 border-b">
                                @if ($payment->payment_proof)
                                    <a href="{{ asset('images/payments/' . basename($payment->payment_proof)) }}" target="_blank" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200">open <span class="mdi mdi-open-in-new"></span></a>
                                @else
                                    <a href="javascript:void(0)" target="_blank" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200">
                                        N/A <span class="mdi mdi-cancel"></span>
                                    </a>
                                @endif
                            </td>
                            <td class="p-4 py-5 border-slate-200 border-b">
                                <a class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200" href="{{ route('platform.payments.update', ['id' => $payment->id]) }}">
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
