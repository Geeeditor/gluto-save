@extends('layouts.auth')
@section('title', 'KYC Status')
@section('content')


    <div class="bg-white shadow-lg mx-auto my-2 p-8 rounded-xl overflow-hidden">
        <h1 class="font-bold text-gray-800 text-2xl tracking-wide">KYC Application Data</h1>
        <p class="mt-1 mb-8 text-gray-500 text-sm">Check your application status</p>

        <form class="flex flex-col space-y-4" enctype="multipart/form-data" action="{{ route('dashboard.kyc.update', $userKYC->id) }}" method="POST">
            @csrf
            @method('PUT')
            @php
            $isDisabled =
                $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved';
        @endphp
            <p class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} text-gray-500 text-center">
                We are sorry your application was rejected and information regarding why can be found on your
                <a href="" class="underline hover:no-underline">notification tab</a>. You can re-apply by uploading the required documents again.
            </p>

            <div class="flex justify-between items-center">
                <label class="font-medium text-gray-700 text-sm">Selfie Photo</label>
                <div class="flex items-center">
                    <a href="{{ asset('images/kyc/' . basename($userKYC->selfie_photo)) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-medium text-white transition duration-200">
                        <span class="mdi mdi-magnify-expand"></span>
                    </a>
                    <input type="file" name="selfie_photo" id="selfie_photo" hidden>
                    <button type="button" class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-green-600 hover:bg-green-700 px-4 py-2 font-medium text-white transition duration-200" onclick="document.getElementById('selfie_photo').click();">
                        Upload <span class="mdil mdil-cloud-upload"></span>
                    </button>
                </div>
            </div>
            <span id="file_photo" class="text-gray-500"></span>

            <div class="flex justify-between items-center">
                <label class="font-medium text-gray-700 text-sm">Document Type</label>
                <select name="document_type" id="document_type" class="bg-gray-200 px-4 py-2 border-gray-300 rounded-md focus:outline-none w-48 text-black" {{ $isDisabled ? 'disabled' : '' }}>
                    <option value="" disabled selected>Select document type</option>
                    <option value="passport" @if ($userKYC->document_type === 'passport') selected @endif>Passport</option>
                    <option value="driver_license" @if ($userKYC->document_type === 'driver_license') selected @endif>Driver's License</option>
                    <option value="national_id" @if ($userKYC->document_type === 'national_id') selected @endif>National ID</option>
                    <option value="voter_card" @if ($userKYC->document_type === 'voter_card') selected @endif>Voter Card</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <label class="font-medium text-gray-700 text-sm">Document ID</label>
                <input type="text" name="document_id" id="document_id" value="{{ $userKYC->document_id }}" class="bg-gray-200 px-4 py-2 border-gray-300 rounded-md focus:outline-none text-black" {{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'readonly' : '' }}>
            </div>

            <div class="flex justify-between items-center">
                <label class="font-medium text-gray-700 text-sm">Document Front</label>
                <div class="flex items-center">
                    <a href="{{ asset('images/kyc/' . basename($userKYC->document_front)) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-medium text-white transition duration-200">
                        <span class="mdi mdi-magnify-expand"></span>
                    </a>
                    <input type="file" name="document_front" id="document_front" hidden>
                    <button type="button" class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-green-600 hover:bg-green-700 px-4 py-2 font-medium text-white transition duration-200" onclick="document.getElementById('document_front').click();">
                        Upload <span class="mdil mdil-cloud-upload"></span>
                    </button>
                </div>
            </div>
            <span id="file_front" class="text-gray-500"></span>

            <div class="flex justify-between items-center">
                <label class="font-medium text-gray-700 text-sm">Document Back</label>
                <div class="flex items-center">
                    <a href="{{ asset('images/kyc/' . basename($userKYC->document_back)) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 font-medium text-white transition duration-200">
                        <span class="mdi mdi-magnify-expand"></span>
                    </a>
                    <input type="file" name="document_back" id="document_back" hidden>
                    <button type="button" class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-green-600 hover:bg-green-700 px-4 py-2 font-medium text-white transition duration-200" onclick="document.getElementById('document_back').click();">
                        Upload <span class="mdil mdil-cloud-upload"></span>
                    </button>
                </div>
            </div>
            <span id="file_back" class="text-gray-500"></span>

            <div class="flex justify-between items-center">
                <label class="font-medium text-gray-700 text-sm">KYC Status</label>
                <p class="{{ $userKYC->application_status === 'pending_approval' ? 'bg-yellow-500 animate-pulse' : ($userKYC->application_status === 'approved' ? 'bg-green-500 animate-none' : 'bg-red-500') }} px-4 py-2 font-medium text-white rounded-md">
                    {{ strtoupper($userKYC->application_status === 'pending_approval' ? 'PENDING APPROVAL' : ($userKYC->application_status === 'approved' ? 'VERIFIED' : 'REJECTED')) }}
                </p>
            </div>

            <button type="submit" class="{{ $userKYC->application_status === 'pending_approval' || $userKYC->application_status === 'approved' ? 'hidden' : 'block' }} bg-[#cf6720] hover:bg-[#914e21] px-4 py-2 rounded-md text-white transition duration-200">SUBMIT</button>
        </form>

        <script>
            function handleFileSelect(inputId, spanId) {
                const fileInput = document.getElementById(inputId);
                const fileNameSpan = document.getElementById(spanId);

                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameSpan.textContent = this.files[0].name;
                    } else {
                        fileNameSpan.textContent = '';
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
