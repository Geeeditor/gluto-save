<?php

namespace App\Http\Controllers;

// use Paystack;
use App\Http\Requests;
// use App\Http\Controllers\Controller;
// use Unicodeveloper\Paystack\Paystack;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Paystack as Paystack;

class PaystackController extends Controller
{



    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function accountStoreCallback (Request $request) {
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data = $response['data'];

        // dd($data);


        $receipt = $this->userService->generateReceipt();


        $paymentData = [
            'status' => $data['status'],
            'email' => $data['customer']['email'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'payment_id' => $data['metadata']['payment_id'],
            'payment_type' => $data['metadata']['payment_type'],
            // 'plan' => $data['metadata']['plan'],
            'trxRef' => $data['metadata']['transaction_reference'] . '/' . $data['reference'],
            'amount' => $data['metadata']['amount'],
        ];

        $user = Auth::user();

        $dashboard = $user->activeDashboard()->find($paymentData['payment_id']);



        if($data['status'] == 'success') {
            $dashboard->update(['dashboard_status' => true]);

            $user->payments()->create([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $dashboard->id,
                'payment_status' => 'approved',
                'receipt' => $receipt . '/' . $data['reference']
            ]);

            return redirect()->route('dashboard')->with('info', 'Your registration payment was successfull, your dashboard is now active.');
        } else {
            $user->payments()->create([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $dashboard->id,
                'payment_status' => 'failed',
                'receipt' => $receipt . '/' . $data['reference']
            ]);

            return redirect()->route('dashboard.payments')->with('error', 'There was an with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
        }





        // dd($data);
    }
    public function retryAccountStoreCallback (Request $request) {
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data = $response['data'];

        // dd($data);


        $receipt = $this->userService->generateReceipt();


        $paymentData = [
            'status' => $data['status'],
            'email' => $data['customer']['email'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'payment_id' => $data['metadata']['payment_id'],
            'payment_type' => $data['metadata']['payment_type'],
            // 'plan' => $data['metadata']['plan'],
            'trxRef' => $data['metadata']['transaction_reference'] . '/' . $data['reference'],
            'amount' => $data['metadata']['amount'],
        ];

        $user = Auth::user();



        $payment = $user->payments()->where('transaction_reference', $data['metadata']['transaction_reference'])->first();

        // dd($payment);

        $dashboard = $user->activeDashboard()->find($payment->payment_id);






        if($data['status'] == 'success') {
            $dashboard->update(['dashboard_status' => true]);

            $payment->update([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $dashboard->id,
                'payment_status' => 'approved',
                'receipt' => $receipt . '/' . $data['reference']
            ]);

            return redirect()->route('dashboard')->with('info', 'Your registration payment was successfull, your dashboard is now active.');
        } else {
            $payment->update([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $dashboard->id,
                'payment_status' => 'failed',
                'receipt' => $receipt . '/' . $data['reference']
            ]);

            return redirect()->route('dashboard.payments')->with('error', 'There was an with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
        }





        // dd($data);
    }

    public function checkoutSubscriptionCallback(Request $request)
    {
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data =  $response['data'];
        $paymentData = [
            'status' => $data['status'],
            'email' => $data['customer']['email'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'subId' => $data['metadata']['generated_sub_id'],
            'payment_type' => $data['metadata']['payment_type'],
            'plan' => $data['metadata']['plan'],
            'trxRef' => $data['metadata']['orderID'] .'/'. $data['reference'],
            'sub_fee' => $data['metadata']['sub_fee'],
            'amount' => $data['metadata']['amount_paid'],
        ];

        $receipt = $this->userService->generateReceipt();


        $user = Auth::user();
        if($paymentData['status'] == 'success'){

            $activeSub = $user->subscriptions()->where('is_primary', true)->update(['is_primary' => false]);

            $package = $user->subscriptions()->create([
                'tier' => $paymentData['plan'],
                'is_primary' => true,
                'sub_id' => $paymentData['subId'],
                'sub_fee' => $paymentData['sub_fee'],
                'package_status' => 'active'
            ]);

            $user->payments()->create([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $package->id,
                'payment_status' => 'approved',
                'receipt' => $receipt . '/' . $data['reference']
            ]);

            $package->increment('total_contribution', $paymentData['amount']);

            return redirect()->route('dashboard.subscriptions')->with('info', 'Your order was processed and your subscription now active');

        } else{
            $user = Auth::user();

            $activeSub = $user->subscriptions()->where('is_primary', true)->update(['is_primary' => false]);

            $package = $user->subscriptions()->create([
                'tier' => $paymentData['plan'],
                'is_primary' => true,
                'sub_id' => $paymentData['subId'],
                'sub_fee' => $paymentData['sub_fee'],
                'package_status' => 'inactive'
            ]);



            $user->payments()->create([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $package->id,
                'payment_status' => 'failed',
                'receipt' => $receipt . '/' . $data['reference']
            ]);

            return redirect()->route('dashboard.payments')->with('error', 'There was an with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
        }
    }

    public function retryPaymentCallback(Request $request) {
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data = $response['data'];

        // dd($data);

        $transactionData = [
            'status' => $data['status'],
            'email' => $data['customer']['email'],
            // 'sub_fee' => $data['metadata']['sub_fee'],
            'amount' => $data['metadata']['amount_paid'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'payment_id' => $data['metadata']['payment_id'],
            'payment_type' => $data['metadata']['payment_type'],
            'trxRef' =>  $data['metadata']['orderID']
        ];

        $user = Auth::user();

        $transaction = $user->payments()->where('transaction_reference',$transactionData['trxRef'])->first();

        // dd($transaction);
        // $package = $user->subscriptions()->find();
        $receipt = $this->userService->generateReceipt();


        if ($transactionData['payment_type'] == 'contribution') {
            if ($data['status'] == 'success') {
                $subscription = $user->subscriptions()->find($transaction->payment_id);

                $transaction->update([
                    'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'approved',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);


                $subscription->increment('total_contribution', $transactionData['amount']);

                $expectedContribution = $subscription->sub_fee * 52;

                if ($subscription->total_contribution >= $expectedContribution) {
                    $subscription->update(['package_status' => 'matured']);
                }


                return redirect()->route('dashboard.payments')->with('info', 'Your subscription repayment was processed successfully');
            } else {
                $transaction->update([
                    'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'failed',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                return redirect()->route('dashboard.payments')->with('error', 'There was issue an with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
            }


        } elseif ($transactionData['payment_type'] == 'wallet_fund') {

            if($data['status'] == 'success') {
                $dashboard = $user->activeDashboard()->find($transaction->payment_id);

                $transaction->update([
                    'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'approved',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                $dashboard->increment('wallet_balance', $transactionData['amount']);


                return redirect()->route('dashboard.payments')->with('info', 'Your wallet funding order  was processed successfully');
            } else {
                $transaction->update([
                    'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'failed',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                return redirect()->route('dashboard.payments')->with('error', 'There was an issue with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
            }

        } elseif ($transactionData['payment_type'] == 'subscription') {
            if ($data['status'] == 'success') {
                $subscription = $user->subscriptions()->find($transaction->payment_id);

                $transaction->update([
                    'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'approved',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                $subscription->update([
                    'package_status' => 'active'
                ]);

                $subscription->increment('total_contribution', $transactionData['amount']);


                return redirect()->route('dashboard.payments')->with('info', 'Your subscription repayment was processed successfully');
            } else {
                $transaction->update([
                    'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'failed',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                return redirect()->route('dashboard.payments')->with('error', 'There was issue an with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
            }


            // return redirect()->route('dashboard.subscriptions')->with('info', 'Your contribution repayment was processed successfully');

        } elseif ($transactionData['payment_type'] == 'debt_pyt') {
            if($data['status'] == 'success') {
                $subscription = $user->subscriptions()->find($transaction->payment_id);

                $subscription->increment('total_contribution', $transactionData['amount']);

                $remainingDebt = $transactionData['amount'] / $subscription->sub_fee;

                // Ensure remainingDebt is not greater than defaulted_weeks
                if ($remainingDebt > $subscription->defaulted_weeks) {
                    $remainingDebt = $subscription->defaulted_weeks; // Set to max allowable value
                }

                // Decrement defaulted_weeks safely
                $subscription->decrement('defaulted_weeks', $remainingDebt);

                $transaction->update([
                    // 'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'approved',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                $expectedContribution = $subscription->sub_fee * 52;

                if ($subscription->total_contribution >= $expectedContribution) {
                    $subscription->update(['package_status' => 'matured']);
                }




                return redirect()->route('dashboard.payments')->with('info', 'Your debt payment was processed successfully');
            } else {
                $transaction->update([
                    // 'amount' => $transactionData['amount'],
                    'payment_method' => $transactionData['payment_method'],
                    'payment_status' => 'failed',
                    'payment_type' => $transactionData['payment_type'],
                    'receipt' => $receipt . '/' . $data['reference'],
                ]);

                return redirect()->route('dashboard.payments')->with('error', 'There was an issue with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
            }

        } else {


            return redirect()->back()->with('error', 'Something went wrong :(.');

        }
    }

    public function makeContributionCallback(Request $request){
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data = $response['data'];

        $user = Auth::user();

        $receipt = $this->userService->generateReceipt();

        $paymentData = [
            'status' => $data['status'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'subID' => $data['metadata']['subID'],
            'payment_type' => $data['metadata']['payment_type'],
            'plan' => $data['metadata']['plan'],
            'trxRef' => $data['metadata']['orderID'],
            'sub_fee' => $data['metadata']['sub_fee'],
            'amount' => $data['metadata']['amount_paid'],
            'receipt' => $receipt . '/' . $data['reference']
        ];


        $subscription = $user->subscriptions()->where('sub_id', $paymentData['subID'])->first();

        if($paymentData['status'] == 'success') {


            $subscription->increment('total_contribution', $paymentData['amount']);

            $user->payments()->create([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $subscription->id,
                'payment_status' => 'approved',
                'receipt' => $paymentData['receipt']
            ]);

            $expectedContribution = $subscription->sub_fee * 52;

            if ($subscription->total_contribution >= $expectedContribution) {
                $subscription->update(['package_status' => 'matured']);
            }



            return redirect()->route('dashboard.subscriptions')->with('info', 'Your contribution payment was processed successfully');

        } else {
            $user->payments()->create([
                // 'payment_proof' => $fileName,
                'amount' => $paymentData['amount'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_method' => $paymentData['payment_method'],
                'payment_type' => $paymentData['payment_type'],
                'payment_id' => $subscription->id,
                'payment_status' => 'failed',
                'receipt' => $paymentData['receipt']
            ]);

            return redirect()->route('dashboard.payments')->with('info', 'There was an issue with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
        }

        // dd($data);
    }

    public function clearDefaultedPaymentCallback(Request $request) {
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data = $response['data'];

        $user = Auth::user();

        $receipt = $this->userService->generateReceipt();

        $paymentData = [
            'status' => $data['status'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'subID' => $data['metadata']['subID'],
            'payment_type' => $data['metadata']['payment_type'],
            'plan' => $data['metadata']['plan'],
            'trxRef' => $data['metadata']['orderID'],
            'sub_fee' => $data['metadata']['sub_fee'],
            'amount' => $data['metadata']['amount_paid'],
            'receipt' => $receipt . '/' . $data['reference']
        ];


        $subscription = $user->subscriptions()->where('sub_id', $paymentData['subID'])->first();

        if ($data['status'] == 'success') {


            $subscription->increment('total_contribution', $paymentData['amount']);

            $remainingDebt = $paymentData['amount'] / $subscription->sub_fee;

            // Ensure remainingDebt is not greater than defaulted_weeks
            if ($remainingDebt > $subscription->defaulted_weeks) {
                $remainingDebt = $subscription->defaulted_weeks; // Set to max allowable value
            }

            // Decrement defaulted_weeks safely
            $subscription->decrement('defaulted_weeks', $remainingDebt);

            $user->payments()->create([
                'amount' => $paymentData['amount'],
                'payment_method' => $paymentData['payment_method'],
                'payment_status' => 'approved',
                'payment_type' => $paymentData['payment_type'],
                'receipt' => $receipt . '/' . $data['reference'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_id' => $subscription->id,
            ]);



            $expectedContribution = $subscription->sub_fee * 52;

            if ($subscription->total_contribution >= $expectedContribution) {
                $subscription->update(['package_status' => 'matured']);
            }




            return redirect()->route('dashboard.subscriptions')->with('info', 'Your debt payment was processed successfully');
        } else {
            $user->payments()->create([
                'amount' => $paymentData['amount'],
                'payment_method' => $paymentData['payment_method'],
                'payment_status' => 'failed',
                'payment_type' => $paymentData['payment_type'],
                'receipt' => $receipt . '/' . $data['reference'],
                'transaction_reference' => $paymentData['trxRef'],
                'payment_id' => $subscription->id,
            ]);

            return redirect()->route('dashboard.payments')->with('error', 'There was an issue with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
        }

        // dd($subscription);
    }

    public function walletFundCallback(Request $request){
        $paystack = new Paystack();

        $response = collect($paystack->getPaymentData());

        $data = $response['data'];

        $user = Auth::user();

        $receipt = $this->userService->generateReceipt();

        $transactionData = [
            'status' => $data['status'],
            'email' => $data['customer']['email'],
            // 'sub_fee' => $data['metadata']['sub_fee'],
            'amount' => $data['metadata']['amount_paid'],
            'payment_method' => $data['metadata']['payment_method'] . '/' . $data['authorization']['channel'],
            'payment_id' => $data['metadata']['payment_id'],
            'payment_type' => $data['metadata']['payment_type'],
            'trxRef' => $data['metadata']['orderID']
        ];

        $dashboard = $user->activeDashboard()->find($transactionData['payment_id']);

        if ($data['status'] == 'success') {

            $user->payments()->create([
                'amount' => $transactionData['amount'],
                'payment_method' => $transactionData['payment_method'],
                'payment_status' => 'approved',
                'payment_type' => $transactionData['payment_type'],
                'receipt' => $receipt . '/' . $data['reference'],
                'transaction_reference' => $transactionData['trxRef'],
                'payment_id' => $dashboard->id,
            ]);

            $dashboard->increment('wallet_balance', $transactionData['amount']);


            return redirect()->route('dashboard')->with('info', 'Your wallet funding order  was processed successfully');
        } else {


            $user->payments()->create([
                'amount' => $transactionData['amount'],
                'payment_method' => $transactionData['payment_method'],
                'payment_status' => 'failed',
                'payment_type' => $transactionData['payment_type'],
                'receipt' => $receipt . '/' . $data['reference'],
                'transaction_reference' => $transactionData['trxRef'],
                'payment_id' => $dashboard->id,
            ]);

            return redirect()->route('dashboard.payments')->with('error', 'There was an issue with processing your payment, please try again if you weren\'t debited and if debited kindly contact support.');
        }


        // dd($data);
    }


}
