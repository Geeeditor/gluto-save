<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Models\PackageSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification as Notification;
use Unicodeveloper\Paystack\Paystack as Paystack;

class DashboardController extends Controller
{
    //

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function account() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;
        $payment = $user->payments()->where('payment_type', 'registration')->first();
        $userDashboard = $user->activeDashboard()->first();

        // dd($payment);
        if(is_null($payment) ) {
            return view('dashboard.account', ['user' => $user, 'profilePic' => $profilePic]);
        } elseif ($payment->payment_status == 'failed') {
            return view('dashboard.account-retry', ['user' => $user, 'profilePic' => $profilePic, 'payment' => $payment]);
        } elseif ($payment->payment_status == 'approved') {
            return redirect()->route('dashboard')->with('info', 'Your account is already active. You are set to explore the dashboard features.');
        }

        return view('dashboard.account-lobby', ['user' => $user, 'profilePic' => $profilePic, 'payment'=> $payment]);
    }

    public function accountStore(Request $request) {
        $data = $request->validate([
           'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();


        $trxType = 'registration';
        $trxRef = $this->userService->generateTrxRef($trxType);
        $userDashboard = $user->activeDashboard()->first();

        // dd($userDashboard);


        if($data['payment_method'] == 'gluto_transfer') {

            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');


                $fileName = 'reg' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put('payments' . $fileName, file_get_contents($image));

            }


            if(is_null($userDashboard)) {


                DB::transaction(function() use ($user, $userDashboard, $fileName, $data, $trxRef, $trxType) {



                    $user->activeDashboard()->create();

                    $user->payments()->create([
                        'amount' => $data['amount'],
                        'payment_method' => $data['payment_method'],
                        'payment_proof' => $fileName,
                        'payment_type' => $trxType,
                        'transaction_reference' => $trxRef,
                        'payment_id' => $user->activeDashboard()->first()->id
                    ]);

                });



                return redirect('dashboard')->with('info', 'Your payment proof has been submitted successfully. Please wait for approval.');
            } elseif(!is_null($userDashboard)) {


                DB::transaction(function() use ($user, $userDashboard, $fileName, $data, $trxRef, $trxType) {
                    if($userDashboard){
                        $userDashboard->delete();
                    }

                    $user->activeDashboard()->create();

                    $user->payments()->create([
                        'amount' => $data['amount'],
                        'payment_method' => $data['payment_method'],
                        'payment_proof' => $fileName,
                        'payment_type' => $trxType,
                        'transaction_reference' => $trxRef,
                        'payment_id' => $user->activeDashboard()->first()->id
                    ]);


                });

                return redirect('dashboard')->with('info', 'Your payment proof has been submitted successfully. Please wait for approval.');
            }

        } elseif($data['payment_method'] == 'paystack'){
            $user->activeDashboard()->create();


            $paymentData = [
                'amount' => (int) round($data['amount'] * 100),
                'email' => $user->email,
                'callback_url' => route('dashboard.account.store.callback'),
                'metadata' => [
                    'name' => $user->name,
                    'payment_method' => $data['payment_method'],
                    'payment_type' => $trxType,
                    'transaction_reference' => $trxRef,
                    'payment_id' => $user->activeDashboard()->first()->id,
                    'amount' => $data['amount']
                ]
            ];

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

        return redirect()->back()->with('error', 'Our system is could not determine your prefered payment method.');
    }

    public function retryAccountStore(Request $request, $id) {
        $data = $request->validate([
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_method' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $user = Auth::user();
        $trxType = 'registration';
        $trxRef = $this->userService->generateTrxRef($trxType);


        $payment = $user->payments()->find($id);


        if($data['payment_method'] == 'gluto_transfer') {

            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'reg' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments', $fileName, 'public');
            }

            // $payment->delete();

            //USE DB when you want to update database in a particuylar order

            DB::transaction(function() use ($user, $payment, $fileName, $data, $trxRef, $trxType) {
                // if($payment){
                //     $payment->delete();
                // }

                $payment->update([
                    'amount' => $data['amount'],
                    'payment_method' => $data['payment_method'],
                    'payment_proof' => $fileName,
                    'payment_status' => 'pending',
                    'payment_type' => $trxType,
                    // 'transaction_reference' => $trxRef
                ]);

            });

            return redirect()->route('dashboard')->with('info', 'Your payment  has been resubmitted successfully. Please wait for confirmation.');

        } elseif ($data['payment_method'] == 'paystack') {

            $paymentData = [
                'amount' => (int) round($data['amount'] * 100),
                'email' => $user->email,
                'callback_url' => route('dashboard.account.retry.callback'),
                'metadata' => [
                    'name' => $user->name,
                    'payment_method' => $data['payment_method'],
                    'payment_type' => $trxType,
                    'transaction_reference' => $payment->transaction_reference,
                    'payment_id' => $payment->id,
                    'amount' => $data['amount']
                ]
            ];

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


            // return redirect()->back()->with('info', 'Paystack payment option unavailable');

        }

        return redirect()->back()->with('info', 'We could not determine your prefered payment option');



    }




    public function index(PackageSubscription $packageSubscription) {
        $user =  Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;
        $accountActive = $user->activeDashboard()->first();
        $payment = $user->payments()->where('payment_type', 'registration')->first();
        // $userSubscription = $user->subscriptions()->where('is_primary', true)->with('package')->first();

        // dd($regPayment);

        $notifications = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc') // Sort by date descending
            ->take(2) // Get the latest two notifications
            ->get();
        $notificationData = [];
        $subscriptions = $user->subscriptions()->get();
        $totalContribution = 0;
        $totalDebt = 0;
        $currentSubscription = $user->subscriptions()->where('is_primary', true)->first() ? $user->subscriptions()->where('is_primary', true)->first() : null;

        // Check if subscriptions are not empty
        if ($subscriptions->isNotEmpty()) {
            // Use sum method to calculate total contributions
            // $totalContribution = $subscriptions->sum('total_contribution');
            $totalContribution = $currentSubscription->total_contribution;

            foreach ($subscriptions as $subscription) {
                // Calculate the debt for each subscription
                $debtForSubscription = $subscription->defaulted_weeks * $subscription->sub_fee;
                $totalDebt += $debtForSubscription; // Add to total debt
            }


        }
            // dd($totalDebt);

        foreach ($notifications as $notification) {
            // Decode the entire 'data' field, which is a JSON string
            $data = json_decode($notification->data, true); // No need for ['title'] here

            if (isset($data)) {
                $notificationData[] = $data;
            }
        }

        if (!isset($notificationData)) {
            $notificationData = [];
        }

        if(is_null($accountActive) || is_null($payment)) {
            return view('dashboard.account', ['user' => $user, 'profilePic' => $profilePic, 'payment' => $payment]);
        } elseif( $payment->payment_status == 'approved' || $accountActive->dashboard_status == true) {
            return view('dashboard.dashboard', ['user' => $user, 'profilePic' => $profilePic,'notificationData' => $notificationData, 'payment' => $payment, 'totalContribution' => $totalContribution, 'totalDebt' => $totalDebt, 'currentSubscription' => $currentSubscription]);
        } elseif(!is_null($accountActive) && $payment->payment_status == 'pending' || $payment->payment_status == 'failed') {
            return view('dashboard.account-lobby', ['user' => $user, 'profilePic' => $profilePic, 'payment' => $payment]);
        }

        return view('dashboard.account-lobby', [
            'user' => $user,
            'profilePic' => $profilePic,
            'payment' => $payment,

        ]);




    }

    public function kyc() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        // Check if the user has a KYC record
        // $userKYC = $user->kyc()->first();

        return view('dashboard.kyc', [
            'user' => $user,
            'profilePic' => $profilePic,
            'userKYC' => $userKYC
        ]);
    }

    public function kycStore(Request $request) {
        $data = $request->validate([
            'selfie_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'document_id' => 'required|string|max:255',
            'document_type' => 'required|string|in:passport,driver_license,national_id,voter_card',
            'document_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'document_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);




        // dd($data);

        $user = Auth::user();

        $userKYC = $user->kyc()->first();

        if ($userKYC) {
            return redirect()->route('dashboard.kyc.status')->with('error', 'You have already submitted your KYC documents.');
        }

        // rename selfie_photo to authenticated name and document_id number and time and save in a folder named 'kyc'
        $selfiePhoto = $request->file('selfie_photo');
        $selfiePhotoName = 'doc_id_' . $data['document_id'] . '_' . time() . '.' . $selfiePhoto->getClientOriginalExtension();
        $selfiePhoto->storeAs('kyc', $selfiePhotoName, 'public');
        $data['selfie_photo'] = $selfiePhotoName;
        // rename document_front to document_id number and time and save in a folder named 'kyc'
        $documentFront = $request->file('document_front');
        $documentFrontName = 'document_id_' . $data['document_id'] . '_' . time() . '.' . $documentFront->getClientOriginalExtension();
        $documentFront->storeAs('kyc', $documentFrontName, 'public');
        $data['document_front'] = $documentFrontName;

        // rename document_back to document_id number and time and save in a folder named 'kyc'
        $documentBack = $request->file('document_back');
        $documentBackName = 'document_id_' . $data['document_id'] . '_' . time() . '.' . $documentBack->getClientOriginalExtension();
        $documentBack->storeAs('kyc', $documentBackName, 'public');
        $data['document_back'] = $documentBackName;
        $data['application_status'] = 'pending_approval';

        // Store the KYC documents
        $kyc = $user->kyc()->create($data);

        return redirect()->route('dashboard.kyc.status')->with('success', 'KYC documents submitted successfully.');
    }

    public function kycUpdate(Request $request, $id) {
        $data = $request->validate([
            'selfie_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_id' => 'required|string|max:255',
            'document_type' => 'required|string|in:passport,driver_license,national_id,voter_card',
            'document_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'document_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $userKYC = $user->kyc()->findOrFail($id);

        // Update the KYC documents if provided
        if ($request->hasFile('selfie_photo')) {
            $selfiePhoto = $request->file('selfie_photo');
            $selfiePhotoName = 'doc_id_' . $data['document_id'] . '_' . time() . '.' . $selfiePhoto->getClientOriginalExtension();
            $selfiePhoto->storeAs('kyc', $selfiePhotoName, 'public');
            $data['selfie_photo'] = $selfiePhotoName;
            $data['application_status'] = 'pending_approval';
        }

        if ($request->hasFile('document_front')) {
            $documentFront = $request->file('document_front');
            $documentFrontName = 'document_id_' . $data['document_id'] . '_' . time() . '.' . $documentFront->getClientOriginalExtension();
            $documentFront->storeAs('kyc', $documentFrontName, 'public');
            $data['document_front'] = $documentFrontName;
            $data['application_status'] = 'pending_approval';
        }

        if ($request->hasFile('document_back')) {
            $documentBack = $request->file('document_back');
            $documentBackName = 'document_id_' . $data['document_id'] . '_' . time() . '.' . $documentBack->getClientOriginalExtension();
            $documentBack->storeAs('kyc', $documentBackName, 'public');
            $data['document_back'] = $documentBackName;
            $data['application_status'] = 'pending_approval';
        }

        // Update the KYC record
        $userKYC->update($data);

        return redirect()->route('dashboard.kyc.status')->with('success', 'KYC documents updated successfully.');
    }

    public function kycStatus() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        // Fetch the user's KYC status
        $userKYC = $user->kyc()->first();

        if (!$userKYC) {
            return redirect()->route('dashboard.kyc')->with('info', 'You are yet to apply for KYC verification.');
        }

        return view('dashboard.kyc-status', [
            'user' => $user,
            'profilePic' => $profilePic,
            'userKYC' => $userKYC
        ]);
    }

    public function subscribe(){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        return view('dashboard.plan', ['user' => $user, 'profilePic' => $profilePic]);

    }

    public function subscriptions() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        // Fetch all subscriptions for the user
        $currentSubscription = $user->subscriptions()->where('is_primary', true)->first();
        $subscriptions = $user->subscriptions()->get();

        // dd($currentSubscription);

        return view('dashboard.subscriptions', [
            'user' => $user,
            'profilePic' => $profilePic,
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions
        ]);
    }

    public function subscribeStore(Request $request) {
        $data = $request->validate([
            'plan' => 'required|string|in:savings,pro,boss',
            'amount' => 'required'
        ],
        [
            'plan.required' => 'Opps reselect a subscription package.',
            'plan.in' => 'The selected plan is invalid.',
        ]);



        $request->session()->put('subscription_plan', $data['plan']);
        $request->session()->put('subscription_amount', $data['amount']);


        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = $user->kyc()->first();

        // dd($userKYC);

        if(!isset($userKYC)){
            return redirect()->route('dashboard.kyc')->with('info', 'Please submit a KYC before subscribing.');
        }

        return redirect()->route('plan.checkout', ['plan' => $data['plan']]);
    }

    public function getPreferedSubscription (Request $request, $plan){

        $plan = $request->session()->get('subscription_plan');
        $amount = $request->session()->get('subscription_amount');
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();

        if(!$plan){
            return redirect()->route('dashboard')->with('info', 'Our system is experiencing an error please try again later');
        }

        return view('dashboard.checkout-plan', ['plan' => $plan, 'amount'=> $amount, 'user' => $user, 'profilePic' => $profilePic]);
    }

    public function checkoutSubscription(Request $request, User $users) {
        $data = $request->validate([
            'payment_proof' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $trxType = 'subscription';
        $plan = $request->session()->get('subscription_plan');
        $amount = $request->session()->get('subscription_amount');
        $subID = $this->userService->generateAccount($users);
        // dd($subID);
        $trxRef = $this->userService->generateTrxRef($trxType, $subID);


        // dd($activeSub);

        $subscription = [
            'sub_id' => $subID,
            'plan' => $plan,
            'amount' =>  $amount,
            'payment_type' => $trxType,
            'trxRef' => $trxRef,
            'payment_method' => $data['payment_method'],
            'sub_fee' => $amount
        ];

        if($data['payment_method'] == 'wallet_balance'){
            $activeDashboard = $user->activeDashboard()->first();


            if($subscription['amount'] > $activeDashboard->wallet_balance) {
                return redirect()->back()->with('error', 'Insufficient Wallet Balance');
            }



            $receipt = $this->userService->generateReceipt();



            DB::transaction(function () use ($user,  $subscription, $request, $activeDashboard, $receipt) {
                $activeDashboard->decrement('wallet_balance', $subscription['amount']);

                $activeSub = $user->subscriptions()->where('is_primary', true)->update(['is_primary' => false]);

                $package = $user->subscriptions()->create([
                    'tier' => $subscription['plan'],
                    'is_primary' => true,
                    'sub_id' => $subscription['sub_id'],
                    'sub_fee' => $subscription['sub_fee'],
                    'package_status' => 'active'
                ]);

                $user->payments()->create([
                    // 'payment_proof' => $fileName,
                    'amount' => $subscription['amount'],
                    'transaction_reference' => $subscription['trxRef'],
                    'payment_method' => $subscription['payment_method'],
                    'payment_type' => $subscription['payment_type'],
                    'payment_id' => $package->id,
                    'payment_status' => 'approved',
                    'receipt' => $receipt
                ]);

                $request->session()->forget(['subscription_plan', 'subscription_amount']);

            });

            return redirect()->route('dashboard.subscriptions')->with('info', 'Your order has been processed');



        } elseif ($data['payment_method'] == 'gluto_transfer') {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'sub' . '_' . $subscription['plan'] . Str::random(3) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments', $fileName, 'public');
            } else {
                return redirect()->back()->with('error', 'Error uploading payment proof please try again.');
            }

            DB::transaction(function () use ($user,  $fileName, $subscription, $request) {
                $activeSub = $user->subscriptions()->where('is_primary', true)->update(['is_primary' => false]);

                $package = $user->subscriptions()->create([
                    'tier' => $subscription['plan'],
                    'is_primary' => true,
                    'sub_id'=> $subscription['sub_id'],
                    'sub_fee' => $subscription['sub_fee']
                ]);

                $user->payments()->create([
                    'payment_proof' => $fileName,
                    'amount' => $subscription['amount'],
                    'transaction_reference' => $subscription['trxRef'],
                    'payment_method' => $subscription['payment_method'],
                    'payment_type' => $subscription['payment_type'],
                    'payment_id' => $package->id //Subscription package id
                ]);

                $request->session()->forget(['subscription_plan', 'subscription_amount']);

            });

            return redirect()->route('dashboard.subscriptions')->with('info', 'Your order is been processed');
        } elseif ($data['payment_method'] == 'paystack') {

            //Paystack Payment



            $paymentData = [
                'email' => $user->email,
                'amount' => (int) round($subscription['amount'] * 100), // Send as integer (4000)
                'callback_url' => route('plan.checkout.store.callback'),
                'metadata' => [
                    'name' => $user->name,
                    'payment_method' => $subscription['payment_method'],
                    'generated_sub_id' => $subscription['sub_id'],
                    'payment_type' => $subscription['payment_type'],
                    'plan' => $subscription['plan'],
                    'orderID' => $trxRef,
                    'sub_fee' => $subscription['sub_fee'],
                    'amount_paid' => $subscription['amount'],
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


                $request->session()->forget(['subscription_plan', 'subscription_amount']);

                return $response;
            } catch (\Exception $e) {
                // Handle the exception
                return redirect()->back()->with('error', $e->getMessage());
                // return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again later.');
            }

            // return redirect()->back()->with('error', 'Something went wrong, please try again.');


        }


        return redirect()->back()->with('info', 'We could not determine your payment method');
    }

    public function switchPackage(Request $request)
    {
        $data = $request->validate([
            'sub_id' => 'required'
        ]);

        $user = Auth::user();

        // Retrieve the current primary subscription
        $currentPackage = $user->subscriptions()->where('is_primary', true)->first();

        // Retrieve the subscription to switch to
        $switchPackage = $user->subscriptions()->where('sub_id', $data['sub_id'])->first();

        // Check if the switch package exists
        if (!$switchPackage) {
            return redirect()->back()->with('error', 'Invalid subscription to switch to.');
        }

        DB::transaction(function () use ($currentPackage, $switchPackage) {
            // If a current package exists, update it to false
            if ($currentPackage) {
                $currentPackage->update(['is_primary' => false]);
            }

            // Set the new primary subscription
            $switchPackage->update(['is_primary' => true]);
        });

        return redirect()->back()->with('success', 'Subscription switched successfully');
    }

    public function contribution()
    {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        // Fetch all subscriptions for the user
        $currentSubscription = $user->subscriptions()->where('is_primary', true)->first();
        $subscriptions = $user->subscriptions()->get();

        if ($currentSubscription == null) {
            return redirect()->route('dashboard.subscriptions')->with('info', 'You don\'t have a subscription package');
        };
        // dd($currentSubscription);

        return view('dashboard.contribution', [
            'user' => $user,
            'profilePic' => $profilePic,
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions
        ]);
    }

    public function claimStatus(){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        // Fetch all subscriptions for the user
        $currentSubscription = $user->subscriptions()->where('is_primary', true)->first();
        $subscriptions = $user->subscriptions()->get();

        if ($currentSubscription == null) {
            return redirect()->route('dashboard.subscriptions')->with('error', 'You don\'t have a subscription package.');
        }

        if ($currentSubscription->package_status !== 'matured') {
            return redirect()->route('dashboard.subscriptions')->with('error', 'Your package is yet to mature');
        }

        // dd($currentSubscription);

        return view('dashboard.subscriptions', [
            'user' => $user,
            'profilePic' => $profilePic,
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions
        ]);
    }


    public function defaultedPayment() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = null;

        // Fetch all subscriptions for the user
        $currentSubscription = $user->subscriptions()->where('is_primary', true)->first();
        $subscriptions = $user->subscriptions()->get();

        if ($currentSubscription == null) {
            return redirect()->route('dashboard.subscriptions')->with('info', 'You don\'t have a subscription package');
        }

        if($currentSubscription->defaulted_weeks >= 1)
        {

        // dd($currentSubscription);

        return view('dashboard.defaulted-payment', [
            'user' => $user,
            'profilePic' => $profilePic,
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions
        ]);

        }

        return redirect()->route('dashboard.subscriptions')->with('info', 'There are no outstanding debts on your current subscription package. Please consider switching to a package for which you have missed payments.');
    }

    public function withdrawal() {
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $userKYC = $user->kyc()->first();
        $dashboard = $user->activeDashboard()->first();

        // Fetch all subscriptions for the user
        // $currentSubscription = $user->subscriptions()->where('is_primary', true)->first();
        $withdrawalAccount = $user->withdrawalAccounts()->get();



        if ($withdrawalAccount == null ) {
            return redirect()->route('dashboard.withdrawal')->with('info', 'Please add a withdrawal account');
        }

        $bankAccounts = $withdrawalAccount->filter(function ($account) {
            return $account->no_bank_details == 0; // Accounts with no bank details
        });


        $cryptoWallet = $withdrawalAccount->filter(function ($account) {
            return $account->no_bank_details == 1; // Accounts with bank details
        });

        // dd($bankAccounts, $cryptoWallet);


        if ($userKYC == null ) {
            return redirect()->route('dashboard.kyc')->with('info', 'Please submit your KYC documents');
        }

        return view('dashboard.make-withdrawal', [
            'user' => $user,
            'profilePic' => $profilePic,
            'bankAccounts' => $bankAccounts,
            'cryptoWallet' => $cryptoWallet,
            'dashboard' => $dashboard
        ]);

    }

    public function withdrawalHistory(){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $withdrawals = $user->withdrawals()->get();

        $bankAccounts = $withdrawals->filter(function ($account) {
            return $account->account_number !== null; // Accounts with no bank details
        });


        $cryptoWallet = $withdrawals->filter(function ($account) {
            return $account->crypto_option !== null; // Accounts with bank details
        });

        // dd($bankAccounts, $cryptoWallet);

        return view('dashboard.withdrawal-history', [
            'user' => $user,
            'profilePic' => $profilePic,
            'withdrawals' => $withdrawals,
            'cryptoWallet' => $cryptoWallet,
            'bankAccounts' => $bankAccounts
        ]);
    }

}


