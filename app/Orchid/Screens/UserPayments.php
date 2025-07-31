<?php

namespace App\Orchid\Screens;

use App\Models\Payments;
use Orchid\Screen\Screen;
use Orchid\Screen\Repository;

use Orchid\Screen\TD;
use App\Models\Payment;
// use App\Models\Payments;
use Orchid\Screen\Action;
// use Orchid\Screen\Layout;
// use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
// use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use App\Models\ActivateDashboard;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Platform\Notifications\DashboardMessage;

class UserPayments extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $userPayments = Payments::with('user')->get();


        $payments = $userPayments->map(function($payment)
        {



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
                'payment_type' => $paymentType,
                'amount' => $payment->amount,
                'payment_method' => $payment->payment_method,
                'payment_status' => $payment->payment_status,
                'transaction_reference' => $payment->transaction_reference,
                'payment_id' => $payment->payment_id,
                'payment_proof' => $payment->payment_proof
            ];
        }



        return [
            'payments' => $payments,
            // 'paymentType' => $paymentData,
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
        return 'User Payments';
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
            Layout::metrics(
                ['Total Submitted Payments' => 'metric.total_payments']
            ),

            Layout::table(
                'payments', [
                    TD::make('id', 'ID'),
                    TD::make('user.name', 'User ID')->width('100px')->cantHide(),
                    TD::make('amount', 'Amount'),
                    TD::make('transaction_reference', 'Trx Ref'),
                    TD::make('payment_method', 'Payment Method'),
                    TD::make('payment_type', 'Payment Type'),
                    TD::make('payment_status', 'Payment Status'),
                    TD::make('action', 'Action')->render(function ($payment) {
                        return Button::make('VIew More')
                            ->method('getPayment')
                            ->parameters(['id' => $payment['id']])
                            ;
                    }),
                ]
            )
        ];
    }

    public function getPayment(Request $request)
    {
        $paymentId = $request->get('id');

        return redirect()->route('platform.payments.update', ['id' => $paymentId]);
    }
}
