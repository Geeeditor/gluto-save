@extends('layouts.auth')
@section('title', 'KYC Status')
@section('content')
    <div class="flex flex-col justify-center md:justify-start bg-white shadow-lg mt-8 p-6 rounded-lg">
        <h1 class="md:self-start font-bold text-3xl md:text-left text-center tracking-wide">KYC APPLICATION DATA</h1>
        <h3 class="md:self-start py-3 text-gray-600 md:text-left text-center">CHECK YOUR APPLICATION STATUS</h3>

        <form class="flex flex-col space-y-4" enctype="multipart/form-data"
            action="{{ route('dashboard.kyc.update', $userKYC->id) }}" method="POST">
            @csrf
            @method('PUT')
            <p
                class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }}  text-gray-500 text-center md:text-left">
                We are sorry your application was rejected and information regarding why can be found on your
                <a href="" class="underline hover:no-underline">notification tab</a>. You can re-apply by uploading the
                required documents again using the upload buttons for each document.
            </p>

            <div class="flex md:flex-row flex-col items-center gap-2 w-full">
                <span class="bg-gray-100 px-2 py-3 md:pl-2 rounded-md md:w-1/3 font-semibold text-black">SELFIE PHOTO</span>
                <div class="flex items-center rounded-lg overflow-hidden">
                    <a href="{{ asset('images/kyc/' . basename($userKYC->selfie_photo)) }}" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-medium text-white transition duration-200">
                        <span class="mdi mdi-magnify-expand"></span>

                    </a>
                    <div class="relative">
                        <input type="file" name="selfie_photo" id="selfie_photo" hidden>
                        <button type="button"
                            class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-green-600 hover:bg-green-700 px-4 py-2 font-medium text-white transition duration-200"
                            onclick="document.getElementById('selfie_photo').click();">
                            Upload <span class="mdil mdil-cloud-upload"></span>
                        </button>
                    </div>
                </div>
            </div>
            <span id="file_photo" class="text-gray-500 md:text-left text-center file-name"></span>

            @php
                $isDisabled =
                    $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved';
            @endphp

            <div class="flex md:flex-row flex-col items-center gap-2 w-full">
                <span class="bg-gray-100 py-3 pl-2 rounded-md md:w-1/3 font-semibold text-black">DOCUMENT TYPE</span>
                <select name="document_type" id="document_type"
                    class="bg-gray-200 px-4 py-2 border-gray-300 rounded-md focus:outline-none w-full md:w-[300px] text-black"
                    {{ $isDisabled ? 'disabled' : '' }}>
                    <option value="" disabled selected>Select document type</option>
                    <option value="passport" @if ($userKYC->document_type === 'passport') selected @endif>Passport</option>
                    <option value="driver_license" @if ($userKYC->document_type === 'driver_license') selected @endif>Driver's License
                    </option>
                    <option value="national_id" @if ($userKYC->document_type === 'national_id') selected @endif>National ID</option>
                    <option value="voter_card" @if ($userKYC->document_type === 'voter_card') selected @endif>Voter Card</option>
                </select>
            </div>

            <div class="flex md:flex-row flex-col items-center gap-2 w-full">
                <span class="bg-gray-100 px-2 py-3 md:pl-2 rounded-md md:w-1/3 font-semibold text-black">DOCUMENT ID</span>
                <input type="text" name="document_id" id="document_id" value="{{ $userKYC->document_id }}"
                    class="bg-gray-200 px-4 py-2 border-gray-300 rounded-md focus:outline-none w-full md:w-fit text-black text-center md:text-start"
                    {{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'readonly' : '' }}>
            </div>

            <div class="flex md:flex-row flex-col items-center gap-2 w-full">
                <span class="bg-gray-100 px-2 py-3 md:pl-2 rounded-md md:w-1/3 font-semibold text-black">DOCUMENT
                    FRONT</span>
                <div class="flex items-center rounded-lg overflow-hidden">
                    <a href="{{ asset('images/kyc/' . basename($userKYC->document_front)) }}" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-medium text-white transition duration-200">
                        <span class="mdi mdi-magnify-expand"></span>

                    </a>
                    <div class="relative">
                        <input type="file" name="document_front" id="document_front" hidden>
                        <button type="button"
                            class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-green-600 hover:bg-green-700 px-4 py-2 font-medium text-white transition duration-200"
                            onclick="document.getElementById('document_front').click();">
                            Upload <span class="mdil mdil-cloud-upload"></span>
                        </button>
                    </div>
                </div>
            </div>
            <span id="file_front" class="text-gray-500 md:text-left text-center file-name"></span>

            <div class="flex md:flex-row flex-col items-center gap-2 w-full">
                <span class="bg-gray-100 px-2 py-3 md:pl-2 rounded-md md:w-1/3 font-semibold text-black">DOCUMENT
                    BACK</span>
                <div class="flex items-center rounded-lg overflow-hidden">
                    <a href="{{ asset('images/kyc/' . basename($userKYC->document_back)) }}" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-medium text-white transition duration-200">
                        <span class="mdi mdi-magnify-expand"></span>

                    </a>
                    <div class="relative">
                        <input type="file" name="document_back" id="document_back" hidden>
                        <button type="button"
                            class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-green-600 hover:bg-green-700 px-4 py-2 font-medium text-white transition duration-200"
                            onclick="document.getElementById('document_front').click();">
                            Upload <span class="mdil mdil-cloud-upload"></span>
                        </button>
                    </div>
                </div>
            </div>
            <span id="file_back" class="text-gray-500 md:text-left text-center file-name"></span>

            <div class="flex md:flex-row flex-col items-center gap-2 w-full">
                <span class="block bg-gray-100 px-2 py-3 md:pl-2 rounded-md md:w-1/3 font-semibold text-black">KYC
                    STATUS</span>
                <p
                    class="{{ $userKYC->application_status === 'pending_approval' ? 'bg-yellow-500 animate-pulse' : ($userKYC->application_status === 'approved' ? 'bg-green-500 animate-none' : 'bg-red-500') }} px-4 py-2 font-medium text-white rounded-md block text-center md:text-left md:w-fit">
                    {{ strtoupper($userKYC->application_status === 'pending_approval' ? 'PENDING APPROVAL' : ($userKYC->application_status === 'approved' ? 'VERIFIED' : 'REJECTED')) }}
                </p>
            </div>

            <button type="submit"
                class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-[#cf6720] hover:bg-[#914e21] px-4 py-2 rounded-md text-white transition duration-200">SUBMIT</button>

        </form>

        <script>
            function handleFileSelect(inputId, spanId) {
                const fileInput = document.getElementById(inputId);
                const fileNameSpan = document.getElementById(spanId);

                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameSpan.textContent = this.files[0].name;
                        fileNameSpan.classList.remove('hidden');
                    } else {
                        fileNameSpan.textContent = '';
                        fileNameSpan.classList.add('hidden');
                    }
                });
            }

            // Initialize the file inputs
            handleFileSelect('selfie_photo', 'file_photo');
            handleFileSelect('document_front', 'file_front');
            handleFileSelect('document_back', 'file_back');
        </script>
    </div>
@endsection
