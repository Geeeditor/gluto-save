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
    <h2 class="mb-4 font-bold text-2xl text-center">Withdrawal Interface</h2>
    <div class="mb-4 text-xl text-center">Your Balance: $<span id="user-balance">1000.00</span></div>

    <div class="bg-gray-200 hover:bg-gray-300 mb-4 p-4 rounded-lg cursor-pointer" id="bank-option">
        <h3 class="font-semibold text-lg">Withdraw to Bank Account</h3>
        <p>Withdraw funds to your bank account.</p>
    </div>

    <div class="bg-gray-200 hover:bg-gray-300 mb-4 p-4 rounded-lg cursor-pointer" id="crypto-option">
        <h3 class="font-semibold text-lg">Withdraw to Crypto Wallet</h3>
        <p>Withdraw funds to your crypto wallet.</p>
    </div>

    <!-- Bank Withdrawal Form -->
    <div class="withdraw-form" id="bank-form">
        <h4 class="mb-2 font-semibold text-lg">Bank Account Withdrawal</h4>
        <div class="mb-4">
            <label for="bank-account-name" class="block mb-1">Account Name</label>
            <input type="text" id="bank-account-name" placeholder="Enter your account name" class="p-2 border border-gray-300 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label for="bank-account-number" class="block mb-1">Account Number</label>
            <input type="text" id="bank-account-number" placeholder="Enter your account number" class="p-2 border border-gray-300 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label for="withdraw-amount-bank" class="block mb-1">Amount</label>
            <input type="number" id="withdraw-amount-bank" placeholder="Enter amount to withdraw" class="p-2 border border-gray-300 rounded w-full" required>
        </div>
        <button class="bg-green-600 hover:bg-green-700 p-2 rounded w-full text-white" onclick="submitBankWithdrawal()">Withdraw</button>
    </div>

    <!-- Crypto Withdrawal Form -->
    <div class="withdraw-form" id="crypto-form">
        <h4 class="mb-2 font-semibold text-lg">Crypto Wallet Withdrawal</h4>
        <div class="mb-4">
            <label for="wallet-address" class="block mb-1">Wallet Address</label>
            <input type="text" id="wallet-address" placeholder="Enter your wallet address" class="p-2 border border-gray-300 rounded w-full" required>
        </div>
        <div class="mb-4">
            <label for="withdraw-amount-crypto" class="block mb-1">Amount</label>
            <input type="number" id="withdraw-amount-crypto" placeholder="Enter amount to withdraw" class="p-2 border border-gray-300 rounded w-full" required>
        </div>
        <button class="bg-green-600 hover:bg-green-700 p-2 rounded w-full text-white" onclick="submitCryptoWithdrawal()">Withdraw</button>
    </div>

    <script>
        document.getElementById('bank-option').addEventListener('click', function() {
            document.getElementById('bank-form').style.display = 'block';
            document.getElementById('crypto-form').style.display = 'none';
        });
    
        document.getElementById('crypto-option').addEventListener('click', function() {
            document.getElementById('crypto-form').style.display = 'block';
            document.getElementById('bank-form').style.display = 'none';
        });
    
        function submitBankWithdrawal() {
            const accountName = document.getElementById('bank-account-name').value;
            const accountNumber = document.getElementById('bank-account-number').value;
            const amount = document.getElementById('withdraw-amount-bank').value;
    
            // Here you would typically send this data to your server
            alert(`Withdrawing $${amount} to bank account ${accountName} (${accountNumber})`);
        }
    
        function submitCryptoWithdrawal() {
            const walletAddress = document.getElementById('wallet-address').value;
            const amount = document.getElementById('withdraw-amount-crypto').value;
    
            // Here you would typically send this data to your server
            alert(`Withdrawing $${amount} to crypto wallet at ${walletAddress}`);
        }
    </script>
</div>


@endsection