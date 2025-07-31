@extends('layouts.auth')
@section('title', 'Make Contribution')
@section('description', 'Gluto HEP: Make Contribution')
@section('content')
    <div class="relative py-3 signup">
        <div class="top-desc mb-1">
            <h1 class="font-bold text-base md:text-3xl uppercase tracking-wide">
                Make Contribution
            </h1>
        </div>


        <div class="bg-gray-100 shadow-gray-300 shadow-lg mx-auto my-2 welcome-modal">




                <div class="mx-auto mt-3 px-5 md:px-7 py-5 rounded-lg investment-details-wrapper">
                    <h3 class="text-md-bold text-2xl">You are about to make a contribution of <span class="font-bold text-green-600 uppercase">N{{ $currentSubscription->sub_fee }}</span> Package </h3>
                    {{-- <h5 class="mt-2 mb-5">Note: Each Plan Spans A Duration Of 52 Weeks</h5> --}}
<br>

                    <form class="d-flex flex-col gap-5 space-mobile" action="{{ route('dashboard.contribution.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('put') --}}
                        <div class="form-inline align-items-center row">
                            <div class="col-sm-4">
                                <label class="text-md">Amount</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number"  value="{{ $currentSubscription->sub_fee }}" placeholder="Enter Amount" readonly required class="form-control input" name="amount">
                            </div>
                        </div>
                        <input type="text" name="sub_id" value="{{ $currentSubscription->sub_id }}" hidden>

                        {{-- <input type="hidden" class="form-control input" value="145914" name="user-id"> --}}

                        {{-- <div class="form-inline align-items-center row" style="display: none;">
                            <div class="col-sm-4">
                                <label class="text-md">Choose Account</label>
                            </div>
                            <div class="col-sm-8" style="position:relative;">
                                <select required name="payment_option" class="form-control select">
                                    <option value="">{{ env('APP_NAME') }} Accounts to fund</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="form-inline align-items-center row">
                            <div class="col-sm-4">
                                <label class="text-md">Payment Option</label>
                            </div>
                            <div class="col-sm-8" style="position:relative;">
                                <select required class="form-control select" id="payment_type" name="payment_method" onchange="togglePaymentDetails()">
                                    <option value="">Select Payment Option</option>
                                    <option value="wallet_balance">Pay from your Wallet Balance</option>
                                    <option value="gluto_transfer">Transfer to Gluto HEP Account</option>
                                    <option value="paystack">Pay with Paystack</option>
                                </select>
                            </div>
                        </div>

                        <div id="gluto_transfer" class="hidden bg-white px-2 py-1 border border-black rounded-md w-full">
                            <p>Account Name: <span>Gluto International</span></p>

                            <div class="d-flex home-referral-text align-center">

                                <div class="flex">
                                    <span class="pr-1">Account Number: 1234567890</span>
                                    <span class="mdi-content-copy mdi" onclick="copyToClipBoard(this)">
                                    </span>
                                </div>
                            <textarea id="copyInput" style="display: none;">1234567890</textarea>
                            </div>

                            <p>Bank Name: <span>First Bank Nigeria</span></p>
                        </div>


                        <div id="payment_upload_container" class="hidden top-0 left-0 fixed justify-center shadow-lg blur-bg blur-bg rounded-lg w-full h-[100vh] md:overflow-hidden overflow-y-scroll">
                            <div style="margin-top: 2%" class="bg-white mx-auto w-11/12 max-w-lg h-fit">
                                <div class="flex justify-between items-start p-6 modal-header">
                                    <div class="flex items-center modal-logo">
                                        <span class="flex justify-center items-center bg-indigo-100 rounded-full w-14 h-14 logo-circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[80px] h-[80px]" viewBox="0 0 512 419.116">
                                                <defs>
                                                    <clipPath id="clip-folder-new">
                                                        <rect width="512" height="419.116" />
                                                    </clipPath>
                                                </defs>
                                                <g id="folder-new" clip-path="url(#clip-folder-new)">
                                                    <path id="Union_1" data-name="Union 1" d="M16.991,419.116A16.989,16.989,0,0,1,0,402.125V16.991A16.989,16.989,0,0,1,16.991,0H146.124a17,17,0,0,1,10.342,3.513L227.217,57.77H437.805A16.989,16.989,0,0,1,454.8,74.761v53.244h40.213A16.992,16.992,0,0,1,511.6,148.657L454.966,405.222a17,17,0,0,1-16.6,13.332H410.053v.562ZM63.06,384.573H424.722L473.86,161.988H112.2Z" fill="#2e44ff" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="flex justify-center items-center bg-transparent hover:bg-indigo-100 rounded focus:outline-none w-9 h-9 cursor-pointer close_payment_modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="none" d="M0 0h24v24H0V0z" />
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" fill="#6a6b76" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h2 class="font-bold text-center modal-title">Upload Proof Of Payment</h2>
                                    <p class="text-gray-600 text-center"> If your payment slip is detected to be fake your account will be flagged and your package terminated.</p>
                                    <div class="flex flex-col justify-center items-center bg-transparent mt-5 p-12 border border-gray-600 hover:border-indigo-500 border-dashed w-full text-center upload-area">
                                        <label for="file" class="flex items-center cursor-pointer custum-file-upload">
                                            <div class="mr-2 icon">
                                                <svg viewBox="0 0 24 24" fill="" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill=""></path>
                                                </svg>
                                            </div>
                                            <div id="file-name" class="text">
                                                <span class="font-bold text-base md:text-2xl capitalize">Click to upload image</span>
                                            </div>
                                            <input id="file" type="file" name="payment_proof" class="hidden" onchange="updateFileName()">
                                        </label>
                                        <span class="mt-2">Drag file(s) here to upload.</span>
                                        <span class="text-gray-600 upload-area-description">
                                            Ensure uploaded image is clear <br />
                                            Supported formats: JPG, PNG, JPEG <br />
                                            Max file size: 2MB
                                        </span>
                                    </div>
                                </div>

                                <div class="flex justify-end p-4 modal-footer">
                                    <div class="mr-3 px-4 py-2 border-2 border-gray-300 rounded cursor-pointer btn-secondary close_payment_modal">Close</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between gap-1 w-full">
                            <div id="payment_upload_btn" class="hidden flex-end cursor-pointer">
                                <span class="btn btn-main proceed">I've Made Payment</span>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-main proceed">Proceed</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        function togglePaymentDetails() {
                            const paymentType = document.getElementById('payment_type').value;
                            const glutoTransfer = document.getElementById('gluto_transfer');
                            const paymentUploadBtn = document.getElementById('payment_upload_btn');

                            if (paymentType === 'gluto_transfer') {
                                glutoTransfer.classList.remove('hidden');
                                paymentUploadBtn.classList.remove('hidden');
                            } else {
                                glutoTransfer.classList.add('hidden');
                                paymentUploadBtn.classList.add('hidden');
                            }
                        }

                        document.querySelectorAll('.close_payment_modal').forEach(button => {
                            button.addEventListener('click', () => {
                                document.getElementById('payment_upload_container').classList.add('hidden');
                            });
                        });

                        document.getElementById('payment_upload_btn').addEventListener('click', () => {
                            document.getElementById('payment_upload_container').classList.remove('hidden');
                        });
                    </script>
                    <script>
                        function updateFileName() {
                            const input = document.getElementById('file');
                            const fileNameDisplay = document.getElementById('file-name').querySelector('span');
                            if (input.files.length > 0) {
                                fileNameDisplay.textContent = input.files[0].name;
                            } else {
                                fileNameDisplay.textContent = 'Click to upload image';
                            }
                        }
                    </script>

                </div>



        </div>


    </div>
@endsection
