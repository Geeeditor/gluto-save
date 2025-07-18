@extends('layouts.auth')
@section('title', 'KYC VERIFICATION')
@section('content')
<h2 class="mb-6 font-semibold text-gray-800 text-2xl tracking-wide">
    <i class="text-[#cf6720] fas fa-check-circle"></i>
    KYC Verification Form
  </h2>

    <form method="post" action="{{ route('dashboard.kyc.store') }}"
    class="space-y-6 bg-white shadow-md p-8 rounded-lg w-full"
    enctype="multipart/form-data"
  >
@csrf

    <!-- Selfie Photo -->
    <div>
      <label
        for="selfie_photo"
        class="flex items-center gap-2 mb-2 font-medium text-gray-700 bloc"
        ><i class="text-[#cf6720] fas fa-camera-retro"></i> Selfie Photo
      </label>
      <input
        type="file"
        id="selfie_photo"
        name="selfie_photo"
        accept="image/*"
        required
        class="block hover:file:bg-green-700 file:bg-green-600 file:mr-4 file:px-4 file:py-2 file:border-0 file:rounded-md w-full file:font-semibold text-gray-500 file:text-white text-sm file:text-sm cursor-pointer"
      />
    </div>

    <!-- Document Type -->
    <div>
      <label
        for="document_type"
        class="flex items-center gap-2 mb-2 font-medium text-gray-700 bloc"
        ><i class="text-[#cf6720] fas fa-id-card"></i> Document Type
      </label>
      <select
        id="document_type"
        name="document_type"
        required
        class="block shadow-sm px-3 py-2 border border-gray-300 focus:border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 w-full text-gray-700"
      >
        <option value="" disabled selected>Select document type</option>
        <option value="passport">Passport</option>
        <option value="driver_license">Driver's License</option>
        <option value="national_id">National ID</option>
        <option value="voter_card">Voter Card</option>
      </select>
    </div>

    <!-- Document ID -->
    <div>
      <label
        for="document_id"
        class="flex items-center gap-2 mb-2 font-medium text-gray-700 bloc"
        ><i class="text-[#cf6720] fas fa-hashtag"></i> Document ID
      </label>
      <input
        type="text"
        id="document_id"
        name="document_id"
        placeholder="Enter your document ID"
        required
        class="block shadow-sm px-3 py-2 border border-gray-300 focus:border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 w-full text-gray-700"
      />
    </div>

    <!-- Document Front Upload -->
    <div>
      <label
        for="document_front"
        class="flex items-center gap-2 mb-2 font-medium text-gray-700 bloc"
        ><i class="text-[#cf6720] fas fa-file-upload"></i> Document Front Upload
      </label>
      <input
        type="file"
        id="document_front"
        name="document_front"
        accept="image/*,application/pdf"
        required
        class="block hover:file:bg-green-700 file:bg-green-600 file:mr-4 file:px-4 file:py-2 file:border-0 file:rounded-md w-full file:font-semibold text-gray-500 file:text-white text-sm file:text-sm cursor-pointer"
      />
    </div>

    <!-- Document Back Upload -->
    <div>
      <label
        for="document_back"
        class="flex items-center gap-2 mb-2 font-medium text-gray-700 bloc"
        ><i class="text-[#cf6720] fas fa-file-upload"></i> Document Back Upload
      </label>
      <input
        type="file"
        id="document_back"
        name="document_back"
        accept="image/*,application/pdf"
        required
        class="block hover:file:bg-green-700 file:bg-green-600 file:mr-4 file:px-4 file:py-2 file:border-0 file:rounded-md w-full file:font-semibold text-gray-500 file:text-white text-sm file:text-sm cursor-pointer"
      />
    </div>

    <button
      type="submit"
      class="bg-green-600 hover:bg-green-700 py-3 rounded-md w-full font-semibold text-white transition"
    >
      Submit KYC
    </button>
  </form>
@endsection
