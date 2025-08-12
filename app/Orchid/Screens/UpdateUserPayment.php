<?php

namespace App\Orchid\Screens;

use Orchid\Screen\TD;
use App\Models\Payments;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use App\Models\ActivateDashboard;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Orchid\Support\Facades\Layout;
use App\Models\PackageSubscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPaymentNotification;
use Orchid\Platform\Notifications\DashboardMessage;

class UpdateUserPayment extends Screen
{
    protected $payment;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param int $id
     * @return array
     */
    public function query(int $id): iterable
    {
        $this->payment = Payments::find($id);

        // dd(vars: 'y');

        if (!$this->payment) {
            Alert::warning("Payment not found.");
            return [];
        }

        return [
            'payment' => $this->payment,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Update User Payment';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
   public function layout(): iterable
{
    return [
        Layout::rows([

            Input::make('payment.payment_id')
            ->title('User Payment Information')
            ->hidden(),


            Input::make('payment.amount')
                ->title('Amount')
                ->readonly(),

            Input::make('payment.transaction_reference')
                ->title('Transaction Reference')
                ->readonly(),

            Input::make('payment.payment_type')
                ->title('Payment Purpose')
                ->readonly(),



            // Clickable link for payment proof


            Input::make('payment.payment_method')
                ->title('Payment Method')
                ->readonly(),



                Select::make('payment.payment_status')
                ->title('Payment Status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'failed' => 'Failed',
                ])
                ->required(),
                // ->disabled($this->payment->payment_status == 'approved'),

            Button::make('Update Transaction')
                ->method('updatePayment')
                ->icon('check'),
        ])
    ];
}

    /**
     * Update the payment status.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePayment(Request $request)
    {
        $data = $request->validate([
            'payment.payment_status' => 'required',
            'payment.transaction_reference' => 'required'
        ]);


        $paymentStatus = $data['payment']['payment_status'];
        $transactionReference = $data['payment']['transaction_reference'];

        // dd($transactionReference);




            $payment = Payments::with('user')->where('transaction_reference', $transactionReference)->first();

        if ($paymentStatus == 'approved' && $payment->payment_status == 'approved') {
            return redirect()->route('platform.payments')->with('message', 'Transaction already has an existing payment status of approved therefore payment status is left unchanged.');
        }



        // Start a database transaction
        DB::transaction(function () use ($payment, $paymentStatus, $transactionReference) {
            // Update the payment status first
            $payment->update(['payment_status' => $paymentStatus]);

            // Generate a receipt number if the payment status is approved
            $receiptNumber = $this->generateReceiptNumber();

            $paymentDetails = [
                'name' => $payment->user->name,
                'amount' => $payment->amount,
                'transaction_reference' => $transactionReference,
                'payment_status' => $paymentStatus,
                'payment_type' => $payment->payment_type,
                'payment_method' => $payment->payment_method,
                'receipt' => $receiptNumber,
            ];

            if ($paymentStatus === 'approved') {
                $payment->update(['receipt' => $receiptNumber]);
            }

            // Determine payment type and act accordingly
            switch ($payment->payment_type) {
                case 'registration':
                    // Update ActivateDashboard status
                    $dashboard = ActivateDashboard::with('user')->where('id', $payment->payment_id)->first();


                    if ($paymentStatus === 'approved') {
                        if ($dashboard) {
                            $dashboard->update(['dashboard_status' => true]);
                        } else {
                            // Handle the case where the dashboard does not exist
                            \Log::warning('Dashboard not found for payment ID: ' . $payment->payment_id);
                            return; // Exit or handle accordingly
                        }
                    }

                    try {

                        Mail::to($payment->user->email)->send(new UserPaymentNotification($paymentDetails));

                        // Mail::raw('This is a test email.', function ($message) {
                        //     $message->to('alfredjoe@me.com')
                        //         ->subject('Test Email');
                        // });

                        \Log::info('Test email sent successfully');
                    } catch (\Exception $e) {
                        // Log the error
                        \Log::error('Error sending test email: ' . $e->getMessage());
                        return redirect()->back()->with('error', $e->getMessage());

                    }

                    $message = 'Payment with transaction ref: ' . $transactionReference . '  ' . $paymentStatus;

                    $dashboard->user->notify(

                        DashboardMessage::make()->title('Trx Notification')->message($message)->type(Color::INFO)
                    );


                    break;

                case 'wallet_fund':
                    $dashboard = ActivateDashboard::with('user')->where('id', $payment->payment_id)->first();
                    if ($paymentStatus === 'approved') {
                        if ($dashboard) {
                            $dashboard->increment('wallet_balance', $payment->amount);
                        } else {
                            // Handle the case where the dashboard does not exist
                            \Log::warning('Dashboard not found for payment ID: ' . $payment->payment_id);
                            return; // Exit or handle accordingly
                        }
                    }

                    try {

                        Mail::to($payment->user->email)->send(new UserPaymentNotification($paymentDetails));

                        // Mail::raw('This is a test email.', function ($message) {
                        //     $message->to('alfredjoe@me.com')
                        //         ->subject('Test Email');
                        // });

                        \Log::info('Test email sent successfully');
                    } catch (\Exception $e) {
                        // Log the error
                        \Log::error('Error sending test email: ' . $e->getMessage());
                        return redirect()->back()->with('error', $e->getMessage());

                    }

                    $message = 'Payment with transaction ref: ' . $transactionReference . ' ' . $paymentStatus;

                    if ($dashboard) { // Check again before accessing user
                        $dashboard->user->notify(
                            DashboardMessage::make()->title('Trx Notification')->message($message)->type(Color::INFO)
                        );
                    } else {
                        // Optionally notify an admin or log an error
                        \Log::warning('Could not send notification. Dashboard is null for payment ID: ' . $payment->payment_id);
                    }
                    break;

                case 'subscription':
                    $subscription = PackageSubscription::where('id', $payment->payment_id)->first();
                    if ($subscription ) {
                        $subscription->update(['package_status' => $paymentStatus === 'approved' ? 'active' : 'inactive']);

                        if ($paymentStatus == 'approved') {
                            $subscription->increment('total_contribution', $payment->amount);
                        } else {
                            // Handle the case where the dashboard does not exist
                            \Log::warning('Dashboard not found for payment ID: ' . $payment->payment_id);
                            return; // Exit or handle accordingly
                        }

                        try {

                            Mail::to($payment->user->email)->send(new UserPaymentNotification($paymentDetails));

                            // Mail::raw('This is a test email.', function ($message) {
                            //     $message->to('alfredjoe@me.com')
                            //         ->subject('Test Email');
                            // });

                            \Log::info('Test email sent successfully');
                        } catch (\Exception $e) {
                            // Log the error
                            \Log::error('Error sending test email: ' . $e->getMessage());
                            return redirect()->back()->with('error', $e->getMessage());

                        }

                        $message = 'Payment with transaction ref: ' . $transactionReference . ' ' . $paymentStatus;
                        $subscription->user->notify(

                            DashboardMessage::make()->title('Trx Notification')->message($message)->type(Color::INFO)
                        );
                    }
                    break;

                case 'contribution':
                    $subscription = PackageSubscription::where('id', $payment->payment_id)->first();
                    if ($subscription) {
                        if ($paymentStatus === 'approved') {
                            $subscription->increment('total_contribution', $payment->amount);




                            $expectedContribution = $subscription->sub_fee * 52;




                            // $packageStatus = $subscription->package_status;

                            if ($subscription->total_contribution == $expectedContribution) {
                                $subscription->update(['package_status' => 'matured']);
                            }

                        } else {
                            // Handle the case where the dashboard does not exist
                            \Log::warning('Dashboard not found for payment ID: ' . $payment->payment_id);
                            return; // Exit or handle accordingly
                        }

                        try {

                            Mail::to($payment->user->email)->send(new UserPaymentNotification($paymentDetails));

                            // Mail::raw('This is a test email.', function ($message) {
                            //     $message->to('alfredjoe@me.com')
                            //         ->subject('Test Email');
                            // });

                            \Log::info('Test email sent successfully');
                        } catch (\Exception $e) {
                            // Log the error
                            \Log::error('Error sending test email: ' . $e->getMessage());
                            return redirect()->back()->with('error', $e->getMessage());

                        }

                        $message = 'Payment with transaction ref: ' . $transactionReference . ' ' . $paymentStatus;
                        $subscription->user->notify(

                            DashboardMessage::make()->title('Trx Notification')->message($message)->type(Color::INFO)
                        );
                    }
                    break;

                case 'debt_pyt':
                    $subscription = PackageSubscription::where('id', $payment->payment_id)->first();
                    if ($subscription) {

                        if ($paymentStatus === 'approved') {
                            $subscription->increment('total_contribution', $payment->amount);

                            $remainingDebt =  $payment->amount / $subscription->sub_fee;

                            // dd($remainingDebt);

                            $subscription->decrement('defaulted_weeks', $remainingDebt);






                            $expectedContribution = $subscription->sub_fee * 52;




                            // $packageStatus = $subscription->package_status;

                            if ($subscription->total_contribution >= $expectedContribution) {
                                $subscription->update(['package_status' => 'matured']);
                            }

                        } else {
                            try {

                                Mail::to($payment->user->email)->send(new UserPaymentNotification($paymentDetails));

                                // Mail::raw('This is a test email.', function ($message) {
                                //     $message->to('alfredjoe@me.com')
                                //         ->subject('Test Email');
                                // });

                                \Log::info('Test email sent successfully');
                            } catch (\Exception $e) {
                                // Log the error
                                \Log::error('Error sending test email: ' . $e->getMessage());
                                return redirect()->back()->with('error', $e->getMessage());

                            }

                            // Handle the case where the dashboard does not exist
                            \Log::warning('Dashboard not found for payment ID: ' . $payment->payment_id);
                            return; // Exit or handle accordingly
                        }



                        try {

                            Mail::to($payment->user->email)->send(new UserPaymentNotification($paymentDetails));

                            // Mail::raw('This is a test email.', function ($message) {
                            //     $message->to('alfredjoe@me.com')
                            //         ->subject('Test Email');
                            // });

                            \Log::info('Test email sent successfully');
                        } catch (\Exception $e) {
                            // Log the error
                            \Log::error('Error sending test email: ' . $e->getMessage());
                            return redirect()->back()->with('error', $e->getMessage());

                        }

                        $message = 'Payment with transaction ref: ' . $transactionReference . ' ' . $paymentStatus;
                        $subscription->user->notify(

                            DashboardMessage::make()->title('Trx Notification')->message($message)->type(Color::INFO)
                        );
                    }
                    break;

                default:
                    // Handle any unexpected payment types
                    Alert::warning('Unexpected payment type.');
                    break;
            }
        });

        Alert::success('Payment status updated successfully.');

        return redirect()->route('platform.payments'); // Redirect back to payment list
    }
    /**
 * Generate a unique receipt number.
 *
 * @return string
 */
private function generateReceiptNumber(): string
{
    $randomCode = Str::random(10); // Generate a random 10-character code
    return 'gluto/hep/' . $randomCode;
}

}
