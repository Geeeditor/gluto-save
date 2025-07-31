@extends('layouts.auth')
@section('title', 'Manage Withdrawal Account')

@section('content')
    <div x-data="{ modal: false }" class="relative p-6">
        <!-- Modal for Adding Withdrawal Account -->
        <div x-transition x-show="modal" class="z-[999] fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 blur-bg">
            <form  method="POST" action="{{ route('withdrawal.accounts.store') }}"
                class="flex flex-col bg-white shadow-md p-8 rounded-lg w-[90%] max-w-lg">
                @csrf <!-- Add CSRF token for security -->

                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-bold text-[#111518] text-2xl">Add Withdrawal Account</h2>
                    <button type="button" @click="modal = false" class="text-gray-500 hover:text-gray-800">
                        <img class="h-8" src="{{ asset('images/icons/close.svg') }}" alt="Close">
                    </button>
                </div>

                <div id="bank-details" class="mb-6">
                    <div class="flex flex-col space-y-4">
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Account Name</span>
                            <input name="account_name" placeholder="e.g., Savings"
                                class="bg-[#f0f3f4] p-4 border rounded-lg focus:outline-none focus:ring-[#146d23] focus:ring-2 w-full h-12" />
                        </label>
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Account Number</span>
                            <input name="account_number" placeholder="Enter account number"
                                class="bg-[#f0f3f4] p-4 border rounded-lg focus:outline-none focus:ring-[#146d23] focus:ring-2 w-full h-12"
                                maxlength="10" />
                        </label>
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Bank Name</span>
                            <input name="bank_name" placeholder="e.g., First National Bank"
                                class="bg-[#f0f3f4] p-4 border rounded-lg focus:outline-none focus:ring-[#146d23] focus:ring-2 w-full h-12" />
                        </label>
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Account Type</span>
                            <select name="account_type" class="flex flex-1 bg-[#f0f3f4] p-4 border-none focus:border-none rounded-lg focus:outline-0 focus:ring-0 w-full min-w-0 h-14" required>
                                <option value="savings" selected>Savings</option>
                                <option value="current" >Current</option>
                            </select>

                        </label>
                    </div>
                </div>

                <div class="flex items-center mb-4">
                    <input type="checkbox" name="no_bank_details" id="no_bank_details" value="1" class="mr-2" />
                    <label for="no_bank_details" class="text-[#111518]">I don't want to add bank details</label>
                </div>

                <!-- Cryptocurrency Details -->
                <div id="crypto-details" style="display: none;" class="mb-6">
                    <div class="flex flex-col space-y-4">
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Wallet Address</span>
                            <input type="text" name="wallet_address" id="wallet_address"
                                placeholder="Enter your wallet address"
                                class="bg-[#f0f3f4] p-4 border rounded-lg focus:outline-none focus:ring-[#146d23] focus:ring-2 w-full h-12" />
                        </label>
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Network</span>
                            <input type="text" name="network" id="network" placeholder="e.g., Ethereum"
                                class="bg-[#f0f3f4] p-4 border rounded-lg focus:outline-none focus:ring-[#146d23] focus:ring-2 w-full h-12" />
                        </label>
                        <label class="flex flex-col">
                            <span class="font-medium text-[#111518]">Cryptocurrency Option</span>
                            <select name="crypto_option" id="crypto_option"
                                class="bg-[#f0f3f4] p-4 border rounded-lg focus:outline-none focus:ring-[#146d23] focus:ring-2 w-full h-12">
                                <option value="bitcoin">Bitcoin</option>
                                <option value="ethereum">Ethereum</option>
                                <option value="litecoin">Litecoin</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-[#146d23] hover:bg-[#0f5e1e] px-6 py-2 rounded-lg font-bold text-white transition duration-200">
                        Add Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="mt-8">
            @if (!$accounts->isEmpty())
                <button  @click="modal = true"
                    class="flex justify-end bg-[#146d23] hover:bg-[#0f5e1e] px-4 py-2 rounded-lg text-white transition duration-200">
                    Add Account
                </button>

                <table class="shadow-lg mt-4 rounded-lg w-full overflow-hidden">
                    <thead class="bg-[#bb6a0a] font-semibold text-white text-sm text-left">
                        <tr>
                            <th class="px-6 py-3 border-[#9a4f00] border-r">Account Name</th>
                            <th class="px-6 py-3 border-[#9a4f00] border-r">Details</th>
                            <th class="px-6 py-3 border-[#9a4f00] border-r">Account Type</th>
                            <th class="px-6 py-3 border-[#9a4f00] border-r">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @foreach ($user->withdrawalAccounts as $account)
                            <tr class="relative hover:bg-gray-50 border-b cursor-pointer">
                                <td class="px-6 py-4 font-medium capitalize">
                                    {{ $account->account_name ?: $account->crypto_option }}</td>
                                <td class="px-6 py-4">
                                    @if ($account->wallet_address)
                                        <div class="max-w-[300px] truncate">
                                            <strong>Wallet Address:</strong> {{ $account->wallet_address }}<br>
                                            <strong>Network:</strong> {{ $account->network }}
                                        </div>
                                    @else
                                        <div>
                                            <strong>Account Number:</strong> {{ $account->account_number }}<br>
                                            <strong>Bank Name:</strong> {{ $account->bank_name }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ ucfirst($account->account_type ) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a class="text-[#bb6a0a] hover:underline"
                                        href="{{ route('withdrawal.accounts.edit', ['id' => $account->id]) }}"
                                        target="_blank" rel="noopener noreferrer">Edit</a>/
                                    <form action="{{ route('withdrawal.accounts.destroy', $account->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[#711e18] hover:underline"
                                            onclick="return confirm('Are you sure you want to delete this account?');"
                                            style="background: none; border: none; padding: 0; cursor: pointer;">
                                            Delete Account
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="py-4 text-gray-500 text-center">
                    No accounts available.
                    <button @click="modal = true"
                        class="bg-[#146d23] hover:bg-[#0f5e1e] px-4 py-2 rounded-lg text-white transition duration-200">Add
                        Account</button>
                </div>
            @endif
        </div>

    </div>

    <script>
        document.getElementById('no_bank_details').addEventListener('change', function() {
            var bankDetails = document.getElementById('bank-details');
            var cryptoDetails = document.getElementById('crypto-details');

            if (this.checked) {
                bankDetails.style.display = 'none';
                cryptoDetails.style.display = 'block';
            } else {
                bankDetails.style.display = 'block';
                cryptoDetails.style.display = 'none';
            }
        });
    </script>
@endsection
