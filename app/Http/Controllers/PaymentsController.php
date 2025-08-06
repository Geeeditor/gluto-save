<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\WithdrawalAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Paystack;
use App\Http\Controllers\DashboardController;

class PaymentsController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $paymentHistory = $user->payments()->get();


        return view('dashboard.payment', ['user' => $user, 'profilePic' => $profilePic, 'paymentHistory' => $paymentHistory]);
    }

    public function retryPayment(Request $request, $id){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $transaction = $user->payments()->where('id', $id)->first();



        if(!$transaction){
            return redirect()->back()->with('error','We could not find this transaction, please try again or contact support');
        }

        return view('dashboard.payment-retry', ['user' => $user, 'profilePic' => $profilePic, 'transaction' => $transaction]);
    }

    public function updatePayment(Request $request, $id){
         $user = Auth::user();
        $data = $request->validate([
            'payment_type'=> 'required',
            'payment_proof'=> 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_method'=> 'required',
            'transaction_reference'=> 'required',
            'amount'=> 'required',
            'payment_id' => 'required',
        ]);

        $transaction = $user->payments()->find($id);

        if(!$transaction){
            return redirect()->back()->with('error','Our system could not find this transaction, please try again or contact support if error persist.');
        }

        $package = $user->subscriptions()->find($data['payment_id']);

        // if (!$package) {
        //     return redirect()->back()->with('error', 'Our system could not find your subscription package please try again, if error persist contact support');
        // }


         // Expected value type
        // id
        // payment_type
        // transaction_reference

        $transactionData = [
            'payment_type' => $data['payment_type'],
            // 'payment_proof' => $data['payment_proof'],
            'payment_method' => $data['payment_method'],
            'transaction_reference' => $data['transaction_reference'],
            'amount'=> $data['amount'],
            'payment_id' => $transaction->id,
            'payment_status' => 'pending',
        ];

        // dd($package);

        if ($data['payment_method'] == 'wallet_balance') {
            $activeDashboard = $user->activeDashboard()->first();

            if($transactionData['payment_type'] == 'contribution') {
            // dd('contribution hit');
                if ($transactionData['amount'] > $activeDashboard->wallet_balance) {
                    return redirect()->back()->with('error', 'Insufficient Wallet Balance');
                }

                $receipt = $this->userService->generateReceipt();

                DB::transaction(function () use ( $transactionData, $transaction, $package, $activeDashboard) {
                    $activeDashboard->decrement('wallet_balance', $transactionData['amount']);

                    $transaction->update([

                        'payment_method' => $transactionData['payment_method'],
                        'payment_type' => $transactionData['payment_type'],
                        'payment_status' => $transactionData['payment_status'],
                        'amount' => $transactionData['amount'],
                    ]);

                    $package->increment('total_contribution', $transactionData['amount']);

                    $expectedContribution = $package->sub_fee * 52;

                    if ($package->total_contribution >= $expectedContribution) {
                        $package->update(['package_status' => 'matured']);
                    }





                });


                return redirect()->route('dashboard.subscriptions')->with('info', 'Your contribution repayment was processed successfully');

            } elseif ($transactionData['payment_type'] == 'wallet_fund') {
                return redirect()->back()->with('error', 'You are not allowed to fund your wallet with your wallet balance kindly use other payment options :(.');

            } elseif ($transactionData['payment_type'] == 'subscription') {
                if ($transactionData['amount'] > $activeDashboard->wallet_balance) {
                    return redirect()->back()->with('error', 'Insufficient Wallet Balance');
                }

                $receipt = $this->userService->generateReceipt();

                DB::transaction(function () use ($transactionData, $transaction, $package, $receipt) {

                    $transaction->update([

                        'payment_method' => $transactionData['payment_method'],
                        'payment_type' => $transactionData['payment_type'],
                        'payment_status' => 'approved',
                        'receipt' => $receipt
                    ]);


                    $package->update([
                        'package_status' => 'active'
                    ]);

                    $package->increment('total_contribution', $transactionData['amount']);


                });


                return redirect()->route('dashboard.subscriptions')->with('info', 'Your contribution repayment was processed successfully');

            } elseif($transactionData['payment_type'] == 'debt_pyt') {
                // dd('debt hit');

                if ($transactionData['amount'] > $activeDashboard->wallet_balance) {
                    return redirect()->back()->with('error', 'Insufficient Wallet Balance');
                }

                $receipt = $this->userService->generateReceipt();

                DB::transaction(function () use ($transactionData, $transaction, $package, $activeDashboard) {
                    $activeDashboard->decrement('wallet_balance', $transactionData['amount']);

                    $package->increment('total_contribution', $transactionData['amount']);

                    $remainingDebt = $transactionData['amount'] / $package->sub_fee;

                    $package->decrement('defaulted_weeks', $remainingDebt);


                    $transaction->update([

                        'payment_method' => $transactionData['payment_method'],
                        'payment_type' => $transactionData['payment_type'],
                        'payment_status' => 'approved',
                        // 'amount' => $transactionData['amount'],
                    ]);

                    $expectedContribution = $package->sub_fee * 52;




                    if ($package->total_contribution == $expectedContribution) {
                        $package->update(['package_status' => 'matured']);
                    }





                });


                return redirect()->route('dashboard.subscriptions')->with('info', 'Your contribution repayment was processed successfully');

            } else {
                return redirect()->back()->with('error', 'Something went wrong :(.');

            }


            // if ($transactionData['amount'] > $activeDashboard->wallet_balance) {
            //     return redirect()->back()->with('error', 'Insufficient Wallet Balance');
            // }



            // $receipt = $this->userService->generateReceipt();

            // DB::transaction(function () use ( $transactionData, $transaction, $package) {


            //     $package->update([
            //         'package_status' => 'pending_activation'
            //     ]);

            //     $transaction->update([

            //         'payment_method' => $transactionData['payment_method'],
            //         'payment_type' => $transactionData['payment_type'],
            //         'payment_status' => $transactionData['payment_status'],
            //         'amount' => $transactionData['amount'],
            //     ]);







            // });


            // return redirect()->route('dashboard.subscriptions')->with('info', 'Your order has been processed');



        } elseif ($data['payment_method'] == 'gluto_transfer') {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'doc' . '_' . Str::random(3) . Str::random(3) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments', $fileName, 'public');
            } else {
                return redirect()->back()->with('error', 'Error uploading payment proof please try again.');
            }

            DB::transaction(function()  use ( $fileName, $transactionData, $transaction, $package){

                if($transactionData['payment_type'] == 'subscription'){
                $package->update([
                   'package_status' => 'pending_activation'
                   ]);
                }

                $transaction->update([
                    'payment_proof' => $fileName,
                    'payment_method' => $transactionData['payment_method'],
                    'payment_type'=> $transactionData['payment_type'],
                    'payment_status'=> $transactionData['payment_status'],
                    'amount' => $transactionData['amount'],
                ]);







            });

            return redirect()->route('dashboard.payments')->with('info', 'Your payment  has been resubmitted successfully. Please wait for confirmation.');


            /* DB::transaction(function () use ($user, $fileName, $transactionData, $request) {
                $user->subscriptions()->findOrFail();


                // $transaction->update([
                //     'tier' => $transactionData['plan'],
                //     'is_primary' => true,
                //     'sub_id' => $transactionData['sub_id'],
                //     'sub_fee' => $transactionData['sub_fee']
                // ]);

                // $user->payments()->update([
                //     'payment_proof' => $fileName,
                //     'amount' => $subscription['amount'],
                //     'transaction_reference' => $subscription['trxRef'],
                //     'payment_method' => $subscription['payment_method'],
                //     'payment_type' => $subscription['payment_type'],
                // ]);

                // $request->session()->forget(['subscription_plan', 'subscription_amount']);

            }); */

            // return redirect()->route('dashboard.subscriptions')->with('info', 'Your order is been processed');
        } elseif ($data['payment_method'] == 'paystack') {
            // Subscription
            // if($transactionData['payment_type'] == 'subscription') {
                $paymentData = [
                    'email' => $user->email,
                    'amount' => (int) round($transactionData['amount'] * 100), // Send as integer (4000)
                    'callback_url' => route('dashboard.payments.update.callback'),
                    'metadata' => [
                        'name' => $user->name,
                        'payment_method' => $transactionData['payment_method'],
                        'payment_type' => $transactionData['payment_type'],
                        'payment_id' => $transactionData['payment_id'],
                        'orderID' => $transactionData['transaction_reference'],
                        'amount_paid' => $transactionData['amount'],
                    ]
                ];
            // }

            //Registration
            // elseif($transactionData['payment_type'] == 'wallet_fund'){

            // }



            try {
                // Initialize Paystack
                $paystack = new Paystack();
                $response = $paystack->getAuthorizationUrl($paymentData)->redirectNow();


                // $request->session()->forget(['subscription_plan', 'subscription_amount']);

                return $response;
            } catch (\Exception $e) {
                // Handle the exception
                return redirect()->back()->with('error', $e->getMessage());
                // return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again later.');
            }

            // return redirect()->back()->with('error', 'Something went wrong, please try again.');
            // return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        }





        return redirect()->back()->with('info', 'We could not determine your payment method');
    }

    public function walletFund(){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $kyc = $user->kyc()->first();

        if ($kyc == null) {
             return redirect()->route('dashboard.kyc')->with('info', 'Please submit your kyc documents.');
        }

        // dd($profilePic);

        return view('dashboard.fundwallet', ['user' => $user, 'profilePic' => $profilePic]);


    }

    public function walletFundCheckout(Request $request) {
        $data = $request->validate([
            'amount' => 'required',
            'payment_method' => 'required',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $user = Auth::user();
        $trxType = 'wallet_fund';
        $trxRef = $this->userService->generateTrxRef($trxType);




        $paymentData = [
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'payment_id' => $user->activeDashboard()->first()->id,
            'payment_type' => $trxType,
            'trxRef' => $trxRef,

        ];

        // dd($paymentData['payment_id']);

        if($data['payment_method'] == 'gluto_transfer'){
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'reg' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments', $fileName, 'public');
            }

            DB::transaction(function () use ($user, $paymentData, $fileName) {
                $user->payments()->create([
                    'amount' => $paymentData['amount'],
                    'payment_proof' => $fileName,
                    'payment_id' => $paymentData['payment_id'],
                    'payment_method' => $paymentData['payment_method'],
                    'payment_type' => $paymentData['payment_type'],
                    'transaction_reference' => $paymentData['trxRef']
                ]);
            });

            return redirect()->route('dashboard.payments')->with('info', 'Your payment  has been submitted. Please wait for confirmation.');



        } elseif ($data['payment_method'] == 'wallet_balance') {
            return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        } elseif ($data['payment_method'] == 'paystack') {
            $transactionData = [
                'email' => $user->email,
                'amount' => (int) round($paymentData['amount'] * 100), // Send as integer (4000)
                'callback_url' => route('dashboard.fund.store.callback'),
                'metadata' => [
                    'name' => $user->name,
                    'payment_method' => $paymentData['payment_method'],
                    'payment_type' => $paymentData['payment_type'],
                    'payment_id' => $paymentData['payment_id'],
                    'orderID' => $paymentData['trxRef'],
                    'amount_paid' => $paymentData['amount'],
                ]
            ];

            try {
                // Initialize Paystack
                $paystack = new Paystack();
                $response = $paystack->getAuthorizationUrl($transactionData)->redirectNow();




                return $response;
            } catch (\Exception $e) {
                // Handle the exception
                return redirect()->back()->with('error', $e->getMessage());
                // return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again later.');
            }

            // return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        }

        return redirect()->back()->with('info', 'We could not determine your payment method');

    }

    public function makeContribution(Request $request) {
        $data = $request->validate([
            'sub_id' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $user = Auth::user();
        $trxType = 'contribution';
        $trxRef = $this->userService->generateTrxRef($trxType, $data['sub_id']);
        $subscription = $user->subscriptions()->where('sub_id', $data['sub_id'])->first();


        // $expectedContribution = $subscription->sub_fee * 52;




        // $packageStatus = $subscription->package_status;

        // if($subscription->total_contribution == $expectedContribution ) {
        //     $packageStatus = 'matured';
        // }






        $paymentData = [
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'payment_id' => $subscription->id,
            'payment_type' => $trxType,
            'trxRef' => $trxRef,
            // 'packageStatus' => $packageStatus
        ];

        if ($data['payment_method'] == 'gluto_transfer') {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'wklysub' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments', $fileName, 'public');
            }

            DB::transaction(function () use ($user, $paymentData, $fileName) {
                $user->payments()->create([
                    'amount' => $paymentData['amount'],
                    'payment_proof' => $fileName,
                    'payment_id' => $paymentData['payment_id'],
                    'payment_method' => $paymentData['payment_method'],
                    'payment_type' => $paymentData['payment_type'],
                    'transaction_reference' => $paymentData['trxRef']
                ]);
            });

            return redirect()->route('dashboard.payments')->with('info', 'Your payment  has been submitted. Please wait for confirmation.');



        } elseif ($data['payment_method'] == 'wallet_balance') {
            $activeDashboard = $user->activeDashboard()->first();


            if ($subscription['amount'] > $activeDashboard->wallet_balance) {
                return redirect()->back()->with('error', 'Insufficient Wallet Balance');
            }



            $receipt = $this->userService->generateReceipt();



            DB::transaction(function () use ($user, $paymentData,  $subscription, $activeDashboard, $receipt) {
                $activeDashboard->decrement('wallet_balance', $paymentData['amount']);

                $subscription->increment('total_contribution', $paymentData['amount']);



                $user->payments()->create([
                    // 'payment_proof' => $fileName,
                    'amount' => $paymentData['amount'],
                    'transaction_reference' => $paymentData['trxRef'],
                    'payment_method' => $paymentData['payment_method'],
                    'payment_type' => $paymentData['payment_type'],
                    'payment_id' => $paymentData['payment_id'],
                    'payment_status' => 'approved',
                    'receipt' => $receipt
                ]);

                // $expectedContribution = $subscription->sub_fee * 52;




                $expectedContribution = $subscription->sub_fee * 52;

                if ($subscription->total_contribution >= $expectedContribution) {
                    $subscription->update(['package_status' => 'matured']);
                }



            });

            return redirect()->route('dashboard.subscriptions')->with('info', 'Your order has been processed');

        } elseif ($data['payment_method'] == 'paystack') {
            $paymentData = [
                'email' => $user->email,
                'amount' => (int) round($paymentData['amount'] * 100), // Send as integer (4000)
                'callback_url' => route('dashboard.contribution.store.callback'),
                'metadata' => [
                    'name' => $user->name,
                    'payment_method' => $paymentData['payment_method'],
                    'subID' => $subscription->sub_id,
                    'payment_type' => $paymentData['payment_type'],
                    'plan' => $subscription->tier,
                    'orderID' => $trxRef,
                    'sub_fee' => $subscription->sub_fee,
                    'amount_paid' => $paymentData['amount'],
                ]
            ];

            \Log::info('Payment Data: ', $paymentData);

            // \Log::info('Payment Data: ', [
            //     'email' => $user->email,
            //     'amount' => number_format($amountInKobo / 100, 2), // Format to 2 decimal places
            //     'payment_type' => $trxType,
            //     'sub_fee' => $subscription['sub_fee'],
            //     'orderID' => $trxRef,
            //     'callback_url' => route('plan.checkout.store.callback'),
            // ]);

            try {
                // Initialize Paystack
                $paystack = new Paystack();
                $response = $paystack->getAuthorizationUrl($paymentData)->redirectNow();




                return $response;
            } catch (\Exception $e) {
                // Handle the exception
                return redirect()->back()->with('error', $e->getMessage());
                // return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again later.');
            }

            // return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        }

        return redirect()->back()->with('info', 'We could not determine your payment method');



    }

    public function claimContribution($sub_id) {
        $user = Auth::user();
        $subscription = $user->subscriptions()->where('sub_id', $sub_id)->first();

        if($subscription->package_status ==! 'matured' ){
            return redirect()->back()->with('error', 'Your package is yet to mature' );
        }

        $dashboard = $user->activeDashboard()->first();

        $contributionQuota = $subscription->total_contribution / ($subscription->sub_fee * 52) * 100;

        if($contributionQuota >= 100.00) {
            // Take the total contributed amount and add it to the funded wallet dashboard balance
            $dashboard->increment('wallet_balance', $subscription->total_contribution);

            $subscription->update(['package_status' => 'terminated']);

            // Optionally, update the subscription status or any other logic
            return redirect()->back()->with('success', 'Contribution claimed successfully!');

        } else {
            return redirect()->back()->with('error', 'We are sorry you can\'t claim your contribution at this time because you have pending payments that needs to be cleared.');
        }


    }

    public function clearDefaultStore(Request $request){
        $data = $request->validate([
            'sub_id' => 'required',
            'amount' => 'required',
            'payment_method' => 'required',
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        // dd($data);


        $user = Auth::user();
        $trxType = 'debt_pyt';
        $trxRef = $this->userService->generateTrxRef($trxType, $data['sub_id']);
        $subscription = $user->subscriptions()->where('sub_id', $data['sub_id'])->first();

        $paymentData = [
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'payment_id' => $subscription->id,
            'payment_type' => $trxType,
            'trxRef' => $trxRef,
            // 'packageStatus' => $packageStatus
        ];


        if ($data['payment_method'] == 'gluto_transfer') {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'debtpyt' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments', $fileName, 'public');
            }

            DB::transaction(function () use ($user, $paymentData, $fileName) {
                $user->payments()->create([
                    'amount' => $paymentData['amount'],
                    'payment_proof' => $fileName,
                    'payment_id' => $paymentData['payment_id'],
                    'payment_method' => $paymentData['payment_method'],
                    'payment_type' => $paymentData['payment_type'],
                    'transaction_reference' => $paymentData['trxRef']
                ]);
            });

            return redirect()->route('dashboard.payments')->with('info', 'Your payment  has been submitted. Please wait for confirmation.');



        } elseif ($data['payment_method'] == 'wallet_balance') {
            $activeDashboard = $user->activeDashboard()->first();


            if($paymentData['amount'] > $activeDashboard->wallet_balance) {
                return redirect()->back()->with('error', 'Your wallet balance is lower than the payment.');
            }

            $receipt = $this->userService->generateReceipt();

            DB::transaction(function () use ($user, $paymentData, $activeDashboard, $subscription, $receipt) {

                $activeDashboard->decrement('wallet_balance', $paymentData['amount']);

                $remainingDebt = $paymentData['amount'] / $subscription->sub_fee;

                $user->payments()->create([
                    'amount' => $paymentData['amount'],
                    // 'payment_proof' => $fileName,
                    'payment_id' => $paymentData['payment_id'],
                    'payment_method' => $paymentData['payment_method'],
                    'payment_type' => $paymentData['payment_type'],
                    'transaction_reference' => $paymentData['trxRef'],
                    'payment_status' => 'approved',
                    'receipt' => $receipt
                ]);

                $subscription->decrement('defaulted_weeks', $remainingDebt);

                $subscription->increment('total_contribution', $paymentData['amount']);

                $expectedContribution = $subscription->sub_fee * 52;

                if ($subscription->total_contribution >= $expectedContribution) {
                    $subscription->update(['package_status' => 'matured']);
                }
            });

            return redirect()->route('dashboard.subscriptions')->with('info', 'Your order has been processed');
        } elseif ($data['payment_method'] == 'paystack') {
            $paymentData = [
                'email' => $user->email,
                'amount' => (int) round($paymentData['amount'] * 100), // Send as integer (4000)
                'callback_url' => route('dashboard.defaulted-payment.store.callback'),
                'metadata' => [
                    'name' => $user->name,
                    'payment_method' => $paymentData['payment_method'],
                    'subID' => $subscription->sub_id,
                    'payment_type' => $paymentData['payment_type'],
                    'plan' => $subscription->tier,
                    'orderID' => $trxRef,
                    'sub_fee' => $subscription->sub_fee,
                    'amount_paid' => $paymentData['amount'],
                ]
            ];

            \Log::info('Payment Data: ', $paymentData);

            // \Log::info('Payment Data: ', [
            //     'email' => $user->email,
            //     'amount' => number_format($amountInKobo / 100, 2), // Format to 2 decimal places
            //     'payment_type' => $trxType,
            //     'sub_fee' => $subscription['sub_fee'],
            //     'orderID' => $trxRef,
            //     'callback_url' => route('plan.checkout.store.callback'),
            // ]);

            try {


                // Initialize Paystack
                $paystack = new Paystack();
                $response = $paystack->getAuthorizationUrl($paymentData)->redirectNow();




                return $response;
            } catch (\Exception $e) {
                // Handle the exception
                return redirect()->back()->with('error', $e->getMessage());
                // return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again later.');
            }


        }

        return redirect()->back()->with('info', 'We could not determine your payment method');
    }

    public function payOutInfo() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;
        $accounts = $user->withdrawalAccounts()->get() ?: [];



        // Check if the user has a KYC record
        // $userKYC = $user->kyc()->first();

        return view('dashboard.withdrawal', [
            'user' => $user,
            'profilePic' => $profilePic,
            'userKYC' => $userKYC,
            'accounts' => $accounts
        ]);
    }

    public function editWithdrawalAccount($id)
    {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;
        $accounts = $user->withdrawalAccounts()->get() ?: [];

        $account = WithdrawalAccount::findOrFail($id); // Fetch the account by ID
        return view('dashboard.edit-withdrawal', compact('account', 'profilePic', 'user')); // Adjust view name as necessary
    }

    public function updateWithdrawalAccount(Request $request, $id) {
        // Validate input based on the type of account
        $account = WithdrawalAccount::findOrFail($id); // Fetch the account by ID

        if ($account->no_bank_details) {
            // Validation for cryptocurrency details
            $data = $request->validate([
                'wallet_address' => 'required|string|max:255',
                'network' => 'required|string|max:255',
                'crypto_option' => 'required|string|in:bitcoin,ethereum,litecoin', // Add more options as needed
            ]);

            // Update cryptocurrency fields
            $account->update(array_merge($data, [
                'account_name' => null, // Clear bank details
                'account_number' => null,
                'bank_name' => null,
                'account_type' => null,
            ]));
        } else {
            // Validation for bank details
            $data = $request->validate([
                'account_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:255',
                'bank_name' => 'required|string|max:255',
                'account_type' => 'required|in:savings,current',
            ]);

            // Update bank fields
            $account->update($data);
        }

        return redirect()->route('dashboard.withdrawal')->with('success', 'Withdrawal account updated successfully.');
    }

    public function storeWithdrawalAccount(Request $request) {
        // Validate the incoming request data
        $data = $request->validate([
            'account_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:10',
            'bank_name' => 'nullable|string|max:255',
            'no_bank_details' => 'boolean',
            'account_type' => 'nullable',
            'wallet_address' => 'nullable|string|max:255',
            'network' => 'nullable|string|max:255',
            'crypto_option' => 'nullable|string', // Ensure valid account type
        ]);

        // Get the authenticated user
        $user = Auth::user();

        if ($request->no_bank_details) {
            // If user does not want to add bank details, set them to null


            $data['account_name'] = null;
            $data['account_number'] = null;
            $data['bank_name'] = null;
            $data['account_type'] = 'Crypto';
        } else {
            $data['crypto_option'] = null;
        }

        // Create a new withdrawal account associated with the user
        $user->withdrawalAccounts()->create(array_merge($data, [
            'user_id' => auth()->id(), // Assuming the user is authenticated
        ]));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Withdrawal account added successfully.');
    }

    public function destroyWithdrawalAccount($id)
    {
        $account = WithdrawalAccount::findOrFail($id); // Fetch the account by ID
        $account->delete(); // Delete the account

        return redirect()->route('dashboard.withdrawal')->with('success', 'Withdrawal account deleted successfully.');
    }

    public function processWithdrawal(Request $request)
{
    // Validate the request data
    $data = $request->validate([

        'amount' => 'required|numeric|min:0.01',
        'withdrawal_type' => 'required|in:bank,crypto', // Specify the withdrawal type
        'withdrawal_id' => 'required',
        // 'account_name' => 'nullable|string',
        // 'account_number' => 'nullable|string',
        // 'bank_name' => 'nullable|string',
        // 'wallet_address' => 'nullable|string',
        // 'network' => 'nullable|string',

    ]);
    $user = Auth::user();
    $trxType = 'withdrawal';
    $appSettings = null;
    $dollarRate = 1560.00;

    // dd($data['amount']);

    $trxRef = $this->userService->generateTrxRef($trxType);

    // dd($data['withdrawal_id']);



    // Check withdrawal type and store accordingly
    if ($request->withdrawal_type === 'bank') {
        $account = $user->withdrawalAccounts()->find($data['withdrawal_id']);

        if($account == null) {
            return redirect()->back()->with('error', 'We couldn\'t find the associated account information, please try again later.');
        }
            // dd($account);


            $activeDashboard = $user->activeDashboard()->first();

            if ($activeDashboard->wallet_balance < $request->amount) {
                return redirect()->back()->with('error', 'Insufficient Balance.');
            }

            $activeDashboard->decrement('wallet_balance',$request->amount);


            // For bank withdrawal
        $withdrawal =$user->withdrawals()->create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'account_name' => $account->account_name,
            'account_number' => $account->account_number,
            'bank_name' => $account->bank_name,
            'withdrawal_status' => 'pending',
            'transaction_reference' => $trxRef,
        ]);
    }
    elseif ($request->withdrawal_type === 'crypto') {
        $account = $user->withdrawalAccounts()->find($data['withdrawal_id']);




        if ($account == null) {
            return redirect()->back()->with('error', 'We couldn\'t find the associated account information, please try again later.');
        }

        // dd($account);

            $activeDashboard = $user->activeDashboard()->first();

            $convertedRate = $data['amount'] * $dollarRate;




            if ($activeDashboard->wallet_balance < $convertedRate) {
                return redirect()->back()->with('error', 'Insufficient Balance.');
            }

            // dd(number_format($convertedRate, 2));



            $activeDashboard->decrement('wallet_balance', $convertedRate);

            // For crypto withdrawal
        $withdrawal = $user->withdrawals()->create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'crypto_option' => $account->crypto_option,
            'wallet_address' => $account->wallet_address,
            'network' => $account->network,
            'withdrawal_status' => 'pending',
            'transaction_reference' => $trxRef,
        ]);
    }

    // return response()->json([
    //     'message' => 'Withdrawal request submitted successfully.',
    //     'withdrawal' => $withdrawal,
    // ], 201);

    return redirect()->route('dashboard.withdrawal.history')->with('info', 'Your withdrawal is pending confirmation');
}



}
