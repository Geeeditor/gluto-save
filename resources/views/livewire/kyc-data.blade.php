<section>
    <style>
        .styled-select {
            width: 100%;
            /* Full width */
            padding: 10px;
            /* Padding for better spacing */
            border: 1px solid #ccc;
            /* Border color */
            border-radius: 5px;
            /* Rounded corners */
            background-color: #fff;
            /* Background color */
            font-size: 16px;
            /* Font size */
            appearance: none;
            /* Remove default arrow */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="5" viewBox="0 0 10 5"><polygon points="0,0 5,5 10,0" fill="%23333"/></svg>');
            /* Custom arrow */
            background-repeat: no-repeat;
            /* No repeat for background image */
            background-position: right 10px center;
            /* Position of the arrow */
            background-size: 10px;
            /* Size of the arrow */
            cursor: pointer;
            /* Pointer cursor */
        }

        .styled-select:focus {
            border-color: #020e1b;
            /* Border color on focus */
            outline: none;
            /* Remove outline */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Shadow on focus */
        }

        .styled-select option {
            padding: 10px;
            /* Padding for options */
        }
    </style>
    @if (session()->has('message'))
        <div class="flex justify-between items-center bg-gray-300 px-1 py-3 rounded-md w-full text-black">
            <span>
                {{ session('message') }}
            </span>
            <span class="mdi-bell-badge-outline text-[20px] mdi"></span>

        </div>
    @endif

    <div class="flex md:flex-row flex-col justify-between md:items-center gap-2 mt-1 mb-3 md:pl-1 w-full">
        <div class="font-[700] text-slate-500">All User KYC can be found here (lookup application by entering the
            Document ID).</div>
        <div id="search-bar" class="md:ml-3">
            <div class="relative w-full min-w-[200px] max-w-sm">
                {{-- <form wire:submit.prevent="search" class="relative"> --}}
                <form class="relative">
                    <input wire:model.live.debounce.400ms="kycRef"
                        class="bg-transparent bg-white shadow-sm focus:shadow-md py-2 pr-11 pl-3 border border-slate-200 hover:border-slate-400 focus:border-slate-400 rounded focus:outline-none w-full h-10 text-slate-700 placeholder:text-slate-400 text-sm transition duration-300 ease"
                        placeholder="Document ID....." />
                    {{-- <button type="submit" class="top-1 right-1 absolute flex items-center bg-white my-auto px-2 rounded w-8 h-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button> --}}
                </form>
            </div>
        </div>
    </div>

    <div
        class="relative flex flex-col bg-white bg-clip-border shadow-md rounded-lg w-full h-full overflow-scroll text-gray-700">
        <table class="w-full min-w-max text-left table-auto">
            <thead class="bg-[#51504f] font-semibold text-white text-sm text-left">
                <tr>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Document ID</th>
                    <th class="px-6 py-3">Document Type</th>
                    <th class="px-6 py-3">Selfie Upload</th>
                    <th class="px-6 py-3">Doc. Front</th>
                    <th class="px-6 py-3">Doc. Back</th>
                    <th class="px-6 py-3">KYC Status</th>
                    <th class="px-6 py-3">Action</th>

                </tr>
            </thead>
            <tbody>
                @if ($kycData->isNotEmpty())
                @foreach ( $kycData as $data )
                <tr class="hover:bg-gray-100">
                    <td class="p-4 py-4 border-slate-200 border-b">
                       {{$data->user->name}}
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        {{$data->document_id}}
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        {{ $data->document_type == 'driver_license' ? 'Driver License' : ($data->document_type == 'national_id'  ? 'NIMC' : ($data->document_type == 'voter_card' ? 'Voters Card' : ($data->document_type == 'passport' ? 'Passport' : 'Unknown'))) }}
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        <a href="{{ asset('images/kyc/' . basename($data->selfie_photo)) }}" target="_blank"
                            class="px-4 py-2 rounded-md font-medium text-gray-600 transition duration-200">open <span
                                class="mdi mdi-open-in-new"></span></a>
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        <a href="{{ asset('images/kyc/' . basename($data->document_front)) }}" target="_blank"
                            class="px-4 py-2 rounded-md font-medium text-gray-600 transition duration-200">open <span
                                class="mdi mdi-open-in-new"></span></a>
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        <a href="{{ asset('images/kyc/' . basename($data->document_back)) }}" target="_blank"
                            class="px-4 py-2 rounded-md font-medium text-gray-600 transition duration-200">open <span
                                class="mdi mdi-open-in-new"></span></a>
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        {{$data->application_status === 'pending_approval' ? 'Pending Approval' : ($data->application_status === 'approved' ? 'Verified' : 'Rejected')}}
                    </td>
                    <td class="p-4 py-4 border-slate-200 border-b">
                        <form wire:submit.prevent="updateStatus({{ $data->id }})" class="flex flex-col justify-start">
                            <select wire:model="status.{{ $data->id }}" class="mb-2 styled-select">
                                <option value="approved">Approved</option>
                                <option value="pending_approval">Pending Approval</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md font-medium text-white transition duration-200">Update</button>
                        </form>
                    </td>

                </tr>
                @endforeach

                @else
                    <tr>
                        <td colspan="10" class="p-4 text-center">No KYC Application found :(<br>
                    <button class="underline"  onclick="window.location.reload();" >reload page <span class="mdi mdi-reload"></span></button> </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>
