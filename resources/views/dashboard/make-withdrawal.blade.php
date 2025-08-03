@extends('layouts.auth')
@section('title', 'KYC VERIFICATION')
@section('content')

    <div class="bg-white shadow-md mx-auto p-6 rounded-lg w-full">
        <style>
            /* Custom styles for the withdrawal form */
            .withdraw-form {
                display: none;
            }
        </style>

        @php
            $dollarRate = 1560;
        @endphp

        <div class="flex items-center">
            <h2 class="mb-4 font-bold text-2xl"><img class="h-[100px]" src="{{ asset('images/icons/wallet.svg') }}"
                    alt=""></h2>
            <div class="mb-4 font-[800] text-[150%] tracking-wider">
                BALANCE: NGN <span id="user-balance font-bold ">{{ number_format($dashboard->wallet_balance, 2) }}</span>
            </div>
        </div>


        <div class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 mb-4 p-4 rounded-lg cursor-pointer"
            id="bank-option">
            <img src="{{ asset('images/icons/bank.svg') }}" alt="">
            <div>
                <h3 class="font-semibold text-lg">Withdraw to Bank Account</h3>
                <p>Withdraw funds to your bank account.</p>
            </div>
        </div>

        <div class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 mb-4 p-4 rounded-lg cursor-pointer"
            id="crypto-option">
            <img src="{{ asset('images/icons/coin.svg') }}" alt="">

            <div>

                <h3 class="font-semibold text-lg">Withdraw to Crypto Wallet</h3>
                <p>Withdraw funds to your crypto wallet.</p>
            </div>
        </div>

        <!-- Bank Withdrawal Form -->
        <form method="post" action="{{ route('dashboard.process-withdrawal') }}" class="withdraw-form" id="bank-form">
            @csrf
            <h4 class="mb-2 font-semibold text-lg">Bank Account Withdrawal</h4>
            <input type="text" name="withdrawal_type" value="bank" hidden>

            <div class="mb-4">

                <label for="withdraw-amount-bank" class="block mb-1">Amount</label>
                <input type="number" name="amount" id="withdraw-amount-bank" placeholder="Enter amount to withdraw"
                    class="p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="mb-4">
                <label for="withdraw-amount-bank" class="block mb-1">Select Withdrawal Account</label>
                <select name="withdrawal_id"
                    class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0"
                    required>
                    <option value="none">None</option>



                    @if (count($bankAccounts) != 0)
                        @foreach ($bankAccounts as $account)
                            <option class="capitalize" value="{{ $account->id }}">{{ ucfirst($account->account_number) }}
                            </option>
                        @endforeach
                    @else
                        <option value="none"> No bank account provided </option>
                    @endif


                </select>
            </div>
            <button class="bg-green-600 hover:bg-green-700 p-2 rounded w-full text-white"
                onclick="submitBankWithdrawal()">Withdraw</button>
        </form>

        <!-- Crypto Withdrawal Form -->
        <form method="post" action="{{ route('dashboard.process-withdrawal') }}" class="withdraw-form" id="crypto-form">
            @csrf
            <h4 class="mb-2 font-semibold text-lg">Crypto Wallet Withdrawal</h4>
            <input type="text" name="withdrawal_type" value="crypto" hidden>

            <div class="mb-4">
                <label for="withdraw-amount-crypto" class="block mb-1">Amount</label>
                <input type="number" id="withdraw-amount-crypto" placeholder="Enter amount to withdraw"
                    class="p-2 border border-gray-300 rounded w-full" required>
                <span class="text-gray-400 text-sm">You'll be getting <span class="amount">$0.00</span> @
                    {{ number_format($dollarRate, 2) }}</span>
                    <input type="number" name="amount" id="amount" value="" readonly style="opacity: 0;">
                <input type="number" value="{{ $dollarRate }}" id="dollarrate" hidden readonly>
            </div>

            <div class="mb-4">
                <label for="withdraw-amount-crypto" class="block mb-1">Payout Wallet</label>
                <select name="withdrawal_id"
                    class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0"
                    required>
                    <option value="none">None</option>


                    @if (count($cryptoWallet) >= 1)
                        @foreach ($cryptoWallet as $account)
                            <option class="capitalize" value="{{ $account->id }}">{{ ucfirst($account->crypto_option) }}
                            </option>
                        @endforeach
                    @else
                        <option value="none">No wallet provided</option>
                    @endif



                </select>
            </div>


            <button class="bg-green-600 hover:bg-green-700 p-2 rounded w-full text-white"
                onclick="submitCryptoWithdrawal()">Withdraw</button>
        </form>

        <script>
            document.getElementById('bank-option').addEventListener('click', function() {
                this.style.backgroundColor = '#c56a082b'; // Use 'this' instead of '$this'
                document.getElementById('bank-form').style.display = 'block';
                document.getElementById('bank-form').scrollIntoView({
                    behaviour: 'smooth',
                    block: 'start'
                })
                document.getElementById('crypto-form').style.display = 'none';
                document.getElementById('crypto-option').style.backgroundColor = '#E5E7EB';

            });

            document.getElementById('crypto-option').addEventListener('click', function() {
                this.style.backgroundColor = '#c56a082b'; // Use 'this' instead of '$this'
                document.getElementById('crypto-form').style.display = 'block';
                document.getElementById('crypto-form').scrollIntoView({
                    behaviour: 'smooth',
                    block: 'start'
                })
                document.getElementById('bank-form').style.display = 'none';
                document.getElementById('bank-option').style.backgroundColor = '#E5E7EB';

            });

            document.addEventListener('DOMContentLoaded', function() {
                const withdrawAmountInput = document.getElementById('withdraw-amount-crypto');
                const dollarRateInput = document.getElementById('dollarrate');
                const amountInput = document.getElementById('amount');
                const amountSpan = document.querySelector('.amount');

                withdrawAmountInput.addEventListener('input', function() {
                    const withdrawAmount = parseFloat(withdrawAmountInput.value) || 0;
                    const dollarRate = parseFloat(dollarRateInput.value) || 1; // Prevent division by zero

                    // Calculate the amount in dollars
                    const calculatedAmount = withdrawAmount / dollarRate;

                    // Update the amount input and span
                    amountInput.value = calculatedAmount;
                    amountSpan.textContent = `$${calculatedAmount.toFixed(2)}`;
                });
            });

            // function submitBankWithdrawal() {
            //     const accountName = document.getElementById('bank-account-name').value;
            //     const accountNumber = document.getElementById('bank-account-number').value;
            //     const amount = document.getElementById('withdraw-amount-bank').value;

            //     // Here you would typically send this data to your server
            //     alert(`Withdrawing $${amount} to bank account ${accountName} (${accountNumber})`);
            // }

            // function submitCryptoWithdrawal() {
            //     const walletAddress = document.getElementById('wallet-address').value;
            //     const amount = document.getElementById('withdraw-amount-crypto').value;

            //     // Here you would typically send this data to your server
            //     alert(`Withdrawing $${amount} to crypto wallet at ${walletAddress}`);
            // }
        </script>
    </div>


@endsection
