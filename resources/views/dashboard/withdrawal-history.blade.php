@extends('layouts.auth')
@section('title', 'Withdrawal History')
@section('content')

    <div class="mt-8">
        @if (!$withdrawals->isEmpty())
        <div class="top-desc my-3">
            <h1 class="font-bold text-base md:text-2xl uppercase tracking-wide">Your Withdrawals  <br>
                <span class="font-thin text-sm">NB: On this page you'll find all your withdrawal transaction. </span>
            </h1>
        </div>

            <table class="shadow-lg mt-4 rounded-lg w-full overflow-hidden">
                <thead class="bg-[#bb6a0a] font-semibold text-white text-sm text-left">
                    <tr>
                        <th class="px-6 py-3 border-[#9a4f00] border-r">Name/Crypto Option</th>
                        <th class="px-6 py-3 border-[#9a4f00] border-r">Details</th>
                        <th class="px-6 py-3 border-[#9a4f00] border-r">Amount</th>
                                        <th class="px-6 py-3 border-[#9a4f00] border-r">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($user->withdrawals as $withdrawal)
                        <tr class="relative hover:bg-gray-50 border-b cursor-pointer">
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
                            <td class="px-6 py-4">


                                @if ($withdrawal->wallet_address)
                                    USD {{ number_format($withdrawal->amount, 2 ) }}
                                @else
                                   NGN {{ number_format($withdrawal->amount, 2 ) }}
                                @endif
                            </td>


                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="{{$withdrawal->withdrawal_status == 'pending' ? 'inline-block bg-yellow-100 px-3 py-1 rounded-full font-semibold text-yellow-800 text-xs' : ($withdrawal->withdrawal_status == 'failed' ? 'inline-block bg-red-100 px-3 py-1 rounded-full font-semibold text-red-800 text-xs' : 'inline-block bg-green-100 px-3 py-1 rounded-full font-semibold text-green-800 text-xs') }}">
                                    {!! $withdrawal->withdrawal_status == 'pending' || $withdrawal->withdrawal_status == 'approved' ? ucfirst($withdrawal->withdrawal_status) : 'Failed' !!}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="py-4 text-gray-500 text-center">
                No Transactions Avaliable.
                <a href="{{route('dashboard.make-withdrawal')}}"
                    class="bg-[#146d23] hover:bg-[#0f5e1e] px-4 py-3 rounded-lg text-white transition duration-200 cursor-pointer">Make withdrawal
                </a>
            </div>
        @endif
    </div>

@endsection
