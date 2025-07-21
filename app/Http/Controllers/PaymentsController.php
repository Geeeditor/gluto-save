<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            'payment_proof'=> 'required',
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
            'payment_proof' => $data['payment_proof'],
            'payment_method' => $data['payment_method'],
            'transaction_reference' => $data['transaction_reference'],
            'amount'=> $data['amount'],
            'payment_id' => $transaction->id,
            'payment_status' => 'pending',
        ];

        // dd($package);

        if ($data['payment_method'] == 'wallet_fund') {
            return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        } elseif ($data['payment_method'] == 'gluto_transfer') {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $fileName = 'sub' . '_' . $package->tier . Str::random(3) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('payments/registration', $fileName, 'public');
            } else {
                return redirect()->back()->with('error', 'Error uploading payment proof please try again.');
            }

            DB::transaction(function()  use ( $fileName, $transactionData, $transaction, $package){


                $package->update([
                   'package_status' => 'pending_activation'
                   ]);

                $transaction->update([
                    'payment_proof' => $fileName,
                    'payment_method' => $transactionData['payment_method'],
                    'payment_type'=> $transactionData['payment_type'],
                    'payment_status'=> $transactionData['payment_status'],
                    'amount' => $transactionData['amount'],
                ]);







            });

            return redirect()->route('dashboard.payments')->with('success', 'Your payment  has been resubmitted successfully. Please wait for confirmation.');


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
            return redirect()->back()->with('error', 'We are still working on this feature kindly use the gluto direct payment option.');
        }





        return redirect()->back()->with('info', 'We could not determine your payment option');
    }



}
