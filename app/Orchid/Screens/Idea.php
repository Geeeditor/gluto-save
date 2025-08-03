<?php

namespace App\Orchid\Screens;

use App\Models\Payments;
use Orchid\Screen\Screen;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;

class Idea extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $userPayments = Payments::with('user')->get();


        $payments = $userPayments->map(function ($payment) {



            return new Repository(($payment->toArray()));
        });


        $paymentData = [];

        foreach ($userPayments as $payment) {
            $paymentType = ''; // Default value

            // Determine the payment type using switch
            switch ($payment->payment_type) {
                case 'registration':
                    $paymentType = 'Registration';
                    break;
                case 'subscription':
                    $paymentType = 'Subscription';
                    break;
                case 'contribution':
                    $paymentType = 'Contribution';
                    break;
                case 'wallet_fund':
                    $paymentType = 'Wallet Funding';
                    break;
                default:
                    $paymentType = 'Unknown';
                    break;
            }

            $paymentData[] = [
                'id' => $payment->id,
                'name' => $payment->user->name,
                'payment_type' => $paymentType,
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
                'payment_status' => $payment->payment_status,
                'transaction_reference' => $payment->transaction_reference,
                'payment_id' => $payment->payment_id,
                'payment_proof' => $payment->payment_proof,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ];
        }

        // dd($paymentData);


        return [
            'payments' => $payments,
            'paymentData' => $paymentData,
            'metric' => [
                    'total_payments' => Payments::count(),
                ]
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Idea';
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
            // Layout::view('platform::partials.update-assets'),

            Layout::view('platform::dummy.payments')
        ];
    }
}
