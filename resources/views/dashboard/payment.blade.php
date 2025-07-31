@extends('layouts.auth')
@section('title', 'My Payments')
@section('content')
    <div class="top-desc my-3">
        <h1 class="font-bold text-base md:text-2xl uppercase tracking-wide">Your Payments <br>
            <span class="font-thin text-sm">NB: On this page you'll find all your payment transaction (e.g. Registration,
                Contribution and Wallet Funding )</span>
        </h1>
    </div>

    <section class="bg-white my-5 md:my-6 overflow-x-auto">
        <table class="shadow-lg rounded-lg min-w-full overflow-hidden">
            <thead class="bg-[#bb6a0a] font-semibold text-white text-sm text-left">
                <tr>
                    <th class="px-6 py-3 border-[#9a4f00] border-r whitespace-nowrap">
                        Payment Type
                    </th>
                    <th class="px-6 py-3 border-[#9a4f00] border-r whitespace-nowrap">
                        Transaction Reference
                    </th>
                    <th class="px-6 py-3 border-[#9a4f00] border-r whitespace-nowrap">
                        Payment Method
                    </th>
                    <th class="px-6 py-3 border-[#9a4f00] border-r whitespace-nowrap">
                        Date
                    </th>
                    <th class="px-6 py-3 border-[#9a4f00] border-r whitespace-nowrap">
                        Receipt
                    </th>
                    <th class="px-6 py-3 whitespace-nowrap">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach ( $paymentHistory as $payment )
                <tr class="hover:bg-gray-50 border-gray-200 border-b cursor-pointer">
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        {{ $payment->payment_type == 'registration' ? 'Registration' : ($payment->payment_type == 'contribution' ? 'Contribution' : ($payment->payment_type == 'wallet_fund' ? 'Wallet Funding' : ($payment->payment_type == 'subscription' ? 'Subscription' : ($payment->payment_type == 'debt_pyt' ? 'Debt Pyt' : 'Unknown')))) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $payment->transaction_reference }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $payment->payment_method == 'gluto_transfer' ? 'Bank Transfer' : ($payment->payment_method == 'wallet_balance' ? 'Wallet Balance' : 'Paystack' )  }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- {{ $payment->created_at->diffForHumans() }} --}}
                        {{ $payment->created_at->format('F j, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-[#bb6a0a] hover:underline" href="{{ asset('receipts/' . $payment->receipt) }}" target="_blank" rel="noopener noreferrer">
                            View Receipt
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">

                        {{-- s --}}

                        <span class="{{$payment->payment_status == 'pending' ? 'inline-block bg-yellow-100 px-3 py-1 rounded-full font-semibold text-yellow-800 text-xs' : ($payment->payment_status == 'failed' ? 'inline-block bg-red-100 px-3 py-1 rounded-full font-semibold text-red-800 text-xs' : 'inline-block bg-green-100 px-3 py-1 rounded-full font-semibold text-green-800 text-xs') }}">
                            {!! $payment->payment_status == 'pending' || $payment->payment_status == 'approved' ? ucfirst($payment->payment_status) : '<a href="' . route('dashboard.payments.retry', $payment->id) . '">Retry</a>' !!}
                        </span>
                    </td>
                </tr>
                @endforeach

                {{-- <tr class="hover:bg-gray-50 border-gray-200 border-b cursor-pointer">
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        Thrift Payment
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        TRX987654321
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Mobile Money
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        2024-05-28
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-[#bb6a0a] hover:underline" href="#" target="_blank" rel="noopener noreferrer">
                            View Receipt
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-block bg-yellow-100 px-3 py-1 rounded-full font-semibold text-yellow-800 text-xs">
                            Pending
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 border-gray-200 border-b cursor-pointer">
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        Loan Repayment
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        TRX112233445
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Debit Card
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        2024-05-20
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-[#bb6a0a] hover:underline" href="#" target="_blank" rel="noopener noreferrer">
                            View Receipt
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-block bg-red-100 px-3 py-1 rounded-full font-semibold text-red-800 text-xs">
                            Failed
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 border-gray-200 border-b cursor-pointer">
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        Contribution
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        TRX556677889
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Bank Transfer
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        2024-05-15
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-[#bb6a0a] hover:underline" href="#" target="_blank" rel="noopener noreferrer">
                            View Receipt
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-block bg-green-100 px-3 py-1 rounded-full font-semibold text-green-800 text-xs">
                            Completed
                        </span>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        Thrift Payment
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        TRX998877665
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Mobile Money
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        2024-05-10
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a class="text-[#bb6a0a] hover:underline" href="#" target="_blank" rel="noopener noreferrer">
                            View Receipt
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-block bg-green-100 px-3 py-1 rounded-full font-semibold text-green-800 text-xs">
                            Completed
                        </span>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </section>
@endsection
