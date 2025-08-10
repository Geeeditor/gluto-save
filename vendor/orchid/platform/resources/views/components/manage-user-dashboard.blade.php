<div>
    {{-- @livewireStyles --}}
    {{-- <script>
        $(document).ready(function() {
            $('#wallet-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'), // Get the action URL from the form
                    data: formData, // Send the serialized data
                    success: function(response) {
                        // Handle a successful response
                        alert(response.message); // You can customize this
                        // Optionally, refresh or update the UI
                    },
                    error: function(xhr) {
                        // Handle errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        if (errors) {
                            for (var key in errors) {
                                errorMessage += errors[key].join(', ') + '\n';
                            }
                        } else {
                            errorMessage = 'An error occurred. Please try again.';
                        }
                        alert(errorMessage);
                    }
                });
            });
        });
        </script>
    <form id="wallet-form" action="{{ route('platform.wallet.update', ['id' => $dashboard->id]) }}" method="post">
        @csrf
        @method('put')
        <div class="flex md:flex-row flex-col justify-between items-center gap-1">
            <div class="mb-2 w-full md:w-1/3">
                <label for="wallet_balance" class="block mb-1 font-medium text-gray-700 text-sm">Amount</label>
                <input type="number" name="amount" placeholder="e.g., 5000" class="shadow-sm px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full transition" required>
            </div>
            <div class="mb-2 w-full md:w-1/3">
                <label for="action" class="block mb-1 font-medium text-gray-700 text-sm">Action</label>
                <select name="action" class="shadow-sm px-3 py-2 border border-gray-300 focus:border-indigo-500 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full transition" required>
                    <option value="">Select Action</option>
                    <option value="add">Add Balance</option>
                    <option value="deduct">Deduct Balance</option>
                </select>
            </div>
            <div class="mt-1 mb-2 w-full md:w-1/3">
                <button type="submit" class="flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 shadow-sm -mt-2 md:mt-0 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 w-full font-semibold text-white transition">
                    Update Wallet
                </button>
            </div>
        </div>
    </form> --}}


    @livewire('manage-dashboard', ['dashboard' => $dashboard])
    {{-- @livewireStyles --}}
{{-- @livewireScripts --}}
</div>
