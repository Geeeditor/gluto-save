<div class="bg-white shadow-lg rounded-xl w-full overflow-hidden">
    <!-- Card Header -->
    <div class="bg-gray-50 p-6 border-gray-200 border-b">
        <h3 class="mt-1 text-gray-500 text-sm">Manage customer information and settings.</h3>
    </div>

    <!-- Customer Information Section -->
    <div class="flex justify-between items-center p-6 border-gray-200 border-b">
        <span class="font-medium text-gray-600 text-md">Customer Username</span>
        <p class="bg-gray-100 px-3 py-1 rounded-md font-semibold text-gray-800 text-md">{{ $dashboard->user->name }}</p>
    </div>

    <!-- Wallet Balance Section -->
    <div class="p-6 border-gray-200 border-b">
        <div class="flex sm:flex-row flex-col sm:justify-between sm:items-center mb-4">
            <h3 class="font-semibold text-gray-700 text-lg">Wallet Balance</h3>
            <p class="font-bold text-green-600 text-lg">NGN {{ number_format($dashboard->wallet_balance, 2) }}</p>
        </div>

        <form  wire:submit.prevent="updateWallet">
            <div class="flex md:flex-row flex-col justify-between items-center gap-1">
                <div class="mb-2 w-full md:w-1/3">
                    <label for="wallet_balance" class="block mb-1 font-medium text-gray-700 text-sm">Amount</label>
                    <input type="number" wire:model="amount" placeholder="e.g., 5000" class="shadow-sm px-3 py-2 border border-gray-300 focus:border-gray-500 rounded-md focus:outline-none focus:ring-[#51504F] focus:ring-2 w-full transition">
                </div>
                <div class="mb-2 w-full md:w-1/3">
                    <label for="action" class="block mb-1 font-medium text-gray-700 text-sm">Action</label>
                    <select wire:model="action" class="shadow-sm px-3 py-2 border border-gray-300 focus:border-gray-500 rounded-md focus:outline-none focus:ring-[#51504F] focus:ring-2 w-full transition">
                        <option value="">Select Action</option>
                        <option value="add">Add Balance</option>
                        <option value="deduct">Deduct Balance</option>
                    </select>
                </div>
                <div class="mt-1 mb-2 w-full md:w-1/3">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="flex justify-center items-center {{ $isLoadingWallet ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-700' }} shadow-sm -mt-2 md:mt-0 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#51504F] focus:ring-offset-2 w-full font-semibold text-white transition">
                        <span wire:loading.remove>Update Wallet</span>
                        <span wire:loading>Updating...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Dashboard Status Section -->
    <div class="p-6">
        <div class="flex sm:flex-row flex-col sm:justify-between sm:items-center mb-4">
            <h3 class="font-semibold text-gray-700 text-lg">Dashboard Status</h3>
            <span class="{{ $dashboard->dashboard_status ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }} px-3 py-1 rounded-full font-medium text-sm">{{ $dashboard->dashboard_status ? 'Active' : 'Inactive' }}</span>
        </div>
        <form wire:submit.prevent="updateStatus">
            <div class="col-span-1">
                <label for="dashboard_status" class="block mb-1 font-medium text-gray-700 text-sm">Change Status</label>
                <select wire:model="status" class="shadow-sm px-3 py-2 border border-gray-300 focus:border-gray-500 rounded-md focus:outline-none focus:ring-[#51504F] focus:ring-2 w-full transition">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="flex justify-center items-center {{ $isLoadingStatus ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-700' }} shadow-sm px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-[#51504F] focus:ring-offset-2 w-full font-semibold text-white transition">
                <span wire:loading.remove>Update Status</span>
                <span wire:loading>Updating...</span>
            </button>
        </form>
    </div>

    <!-- Session Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 p-4 border border-green-300 rounded-md text-green-800">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 p-4 border border-red-300 rounded-md text-red-800">
            {{ session('error') }}
        </div>
    @endif
</div>
