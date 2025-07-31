@extends('layouts.auth')
@section('title', 'Manage Withdrawal Account')

@section('content')
    <div>
        <form method="POST" action="{{ route('withdrawal.accounts.update', $account->id) }}" class="relative flex flex-col justify-between bg-white min-h-screen size-full overflow-x-hidden">
            @csrf <!-- Add CSRF token for security -->
            @method('PUT') <!-- Specify the PUT method for updates -->
        
            <div>
                <div class="flex justify-between items-center bg-white p-4 pb-2">
                    <h2 class="flex-1 font-bold text-[#111518] text-lg text-center leading-tight tracking-[-0.015em]">Edit Withdrawal Account</h2>
                    <div class="flex items-center size-12 text-[#111518] shrink-0" data-icon="X" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path>
                        </svg>
                    </div>
                </div>
        
                @if ($account->no_bank_details)
                    <!-- Cryptocurrency Fields -->
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Wallet Address</p>
                            <input name="wallet_address" value="{{ $account->wallet_address }}" placeholder="Enter your wallet address" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required />
                        </label>
                    </div>
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Network</p>
                            <input name="network" value="{{ $account->network }}" placeholder="e.g., Ethereum" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required />
                        </label>
                    </div>
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Cryptocurrency Option</p>
                            <select name="crypto_option" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required>
                                <option value="bitcoin" {{ $account->crypto_option == 'bitcoin' ? 'selected' : '' }}>Bitcoin</option>
                                <option value="ethereum" {{ $account->crypto_option == 'ethereum' ? 'selected' : '' }}>Ethereum</option>
                                <option value="litecoin" {{ $account->crypto_option == 'litecoin' ? 'selected' : '' }}>Litecoin</option>
                            </select>
                        </label>
                    </div>
                @else
                    <!-- Bank Details Fields -->
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Account Name</p>
                            <input name="account_name" value="{{ $account->account_name }}" placeholder="e.g., Savings" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required />
                        </label>
                    </div>
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Account Number</p>
                            <input name="account_number" value="{{ $account->account_number }}" placeholder="Enter account number" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required />
                        </label>
                    </div>
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Bank Name</p>
                            <input name="bank_name" value="{{ $account->bank_name }}" placeholder="e.g., First National Bank" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required />
                        </label>
                    </div>
                    <div class="flex flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col flex-1 min-w-40">
                            <p class="pb-2 font-medium text-[#111518] text-base leading-normal">Account Type</p>
                            <select name="account_type" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required>
                                <option value="savings" {{ $account->account_type == 'savings' ? 'selected' : '' }}>Savings</option>
                                <option value="current" {{ $account->account_type == 'current' ? 'selected' : '' }}>Current</option>
                            </select>
                        </label>
                    </div>
                @endif
            </div>
        
            <div>
                <div class="flex px-4 py-3">
                    <button type="submit" class="flex flex-1 justify-center items-center bg-[#146d23] px-5 rounded-lg min-w-[84px] h-12 overflow-hidden font-bold text-white text-base leading-normal tracking-[0.015em] cursor-pointer">
                        <span class="truncate">Update Account</span>
                    </button>
                </div>
                <div class="bg-white h-5"></div>
            </div>
        </form>






    </div>
@endsection
