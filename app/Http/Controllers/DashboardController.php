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

class DashboardController extends Controller
{
    //

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    private function getUserPlaceholderImage()
    {
        $user = Auth::user();

        if ($user && $user->display_pic === null) {
            $usernames = $user->name; // Example input

            $displayImages = explode(" ", $usernames); // Split the string into an array

            // Select the first letter of each username
            $firstLettersArray = array_map(function ($username) {
                return strtoupper(substr($username, 0, 1)); // Get the first letter and convert to uppercase
            }, $displayImages);

            // Join the first letters into a string
            $firstLetters = implode('', $firstLettersArray);

            // Create the placeholder URL
            return 'https://placehold.co/300x300/000000/FFF?text=' . $firstLetters;
        }

        // Return a default image or null if the display picture exists
        return 'https://placehold.co/300x300/000000/FFF?text=JD'; // or a default placeholder URL
    }

    private function generateTrxRef($trxType, $subID = null) {
        $transactionReference = '';

        if ($trxType == 'registration') {
            $transactionReference = 'ghep/reg/' . Str::random(5)  . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'subscription') {
            if (is_null($subID)) {
                throw new \InvalidArgumentException("subID is required for subscription transactions.");
            }
            $transactionReference = 'ghep/sub/' . $subID . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'contribution') {
            if (is_null($subID)) {
                throw new \InvalidArgumentException("subID is required for contribution transactions.");
            }
            $transactionReference = 'ghep/wkpyt/' . $subID . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'withdrawal') {
            $transactionReference = 'ghep/debit/' . Str::random(5)  . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } else {
            throw new \InvalidArgumentException("Invalid payment type: $trxType");
        }

        return $transactionReference;
    }

    private function generateAccount(User $users) {


        // Retrieve existing account IDs from subscriptions
        $existingNumbers = $users->subscriptions->pluck('sub_id')->toArray();

        if($existingNumbers == null) {
            $existingNumbers = ['12345678910', '10987654321'];
        }

        do {
            // Generate an 11-digit random number
            $accountNumber = str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
        } while (in_array($accountNumber, $existingNumbers));

        return $accountNumber;
    }


    public function account() {
        $user = Auth::user();
        $profilePic = $this->getUserPlaceholderImage();
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
        $profilePic = $this->getUserPlaceholderImage();


        $trxType = 'registration';
        $trxRef = $this->generateTrxRef($trxType);
        $userDashboard = $user->activeDashboard()->first();

        // dd($userDashboard);


        if($data['payment_method'] == 'gluto_transfer') {

            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');


                $fileName = 'reg' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put('/payments/registration/' . $fileName, file_get_contents($image));

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
            return redirect()->back()->with('info', 'Paystack payment option unavailable');
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
        $trxRef = $this->generateTrxRef($trxType);


        $payment = $user->payments()->find($id);


        if($data['payment_method'] == 'gluto_transfer') {

            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'reg' . '_' . Str::random(4) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments/registration', $fileName, 'public');
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
                    'transaction_reference' => $trxRef
                ]);

            });

            return redirect()->route('dashboard')->with('info', 'Your payment  has been resubmitted successfully. Please wait for confirmation.');

        } elseif ($data['payment_method'] == 'paystack') {
            //Paystack Payment

            return redirect()->back()->with('info', 'Paystack payment option unavailable');

        }

        return redirect()->back()->with('info', 'We could not determine your prefered payment option');



    }




    public function index(PackageSubscription $packageSubscription) {
        $user =  Auth::user();
        $profilePic = $this->getUserPlaceholderImage();
        $userKYC = null;
        $accountActive = $user->activeDashboard()->first();
        $payment = $user->payments()->where('payment_type', 'registration')->first();
        // $userSubscription = $user->subscriptions()->where('is_primary', true)->with('package')->first();

        // dd($regPayment);

        $notifications = DB::table('notifications')->where('notifiable_id', $user->id)->get();
        $notificationData = [];

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
            return view('dashboard.dashboard', ['user' => $user, 'profilePic' => $profilePic,'notificationData' => $notificationData, 'payment' => $payment]);
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
        $profilePic = $this->getUserPlaceholderImage();
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
        $profilePic = $this->getUserPlaceholderImage();
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
        $profilePic = $this->getUserPlaceholderImage();
        $userKYC = null;

        return view('dashboard.plan', ['user' => $user, 'profilePic' => $profilePic]);

    }

    public function subscriptions() {
        $user = Auth::user();
        $profilePic = $this->getUserPlaceholderImage();
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
        $profilePic = $this->getUserPlaceholderImage();
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
        $profilePic = $this->getUserPlaceholderImage();

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
        $subID = $this->generateAccount($users);
        $trxRef = $this->generateTrxRef($trxType, $subID);


        // dd($activeSub);

        $subscription = [
            'sub_id' => $subID,
            'plan' => $plan,
            'amount' => $amount,
            'payment_type' => $trxType,
            'trxRef' => $trxRef,
            'payment_method' => $data['payment_method'],
            'sub_fee' => $amount
        ];

        if($data['payment_method'] == 'wallet_fund'){
            return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        } elseif ($data['payment_method'] == 'gluto_transfer') {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'sub' . '_' . $subscription['plan'] . Str::random(3) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments/registration', $fileName, 'public');
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
            return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        }





        return redirect()->back()->with('info', 'We could not determine your payment option');
    }

}

