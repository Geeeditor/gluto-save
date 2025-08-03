<?php

namespace App\Orchid\Screens;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
// use Illuminate\Support\Facades\Request;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Orchid\Support\Facades\Layout;
use Orchid\Platform\Notifications\DashboardMessage;



class UpdateUserWithdrawal extends Screen
{
    protected $payment;

    public function query(int $id): iterable
    {
        $this->payment = Withdrawal::find($id);

        if (!$this->payment) {
            Alert::warning("Withdrawal not found.");
            return [];
        }

        return [
            'payment' => $this->payment,
        ];
    }

    public function name(): ?string
    {
        return 'Update User Withdrawal Transaction';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        // return [
        //     Layout::rows([
        //         Input::make('payment.user_id')
        //             ->title('User ID')
        //             ->readonly(),

        //         Input::make('payment.transaction_reference')
        //             ->title('Transaction Reference')
        //             ->readonly(),

        //         Input::make('payment.amount')
        //             ->title('Amount')
        //             ->readonly(),

        //         Input::make('payment.withdrawal_status')
        //             ->title('Current Withdrawal Status')
        //             ->readonly(),

        //         // Show bank details if bank_name is not null
        //         Input::make('payment.bank_name')
        //             ->title('Bank Name')
        //             ->readonly()
        //             ->hidden(!$this->payment->bank_name), // Hide if bank_name is null

        //         Input::make('payment.account_name')
        //             ->title('Account Name')
        //             ->readonly()
        //             ->hidden(!$this->payment->account_name), // Hide if account_name is null

        //         Input::make('payment.account_number')
        //             ->title('Account Number')
        //             ->readonly()
        //             ->hidden(!$this->payment->account_number), // Hide if account_number is null

        //         // Show crypto details if crypto_option is not null
        //         Input::make('payment.wallet_address')
        //             ->title('Wallet Address')
        //             ->readonly()
        //             ->hidden(!$this->payment->wallet_address), // Hide if wallet_address is null

        //         Input::make('payment.network')
        //             ->title('Network')
        //             ->readonly()
        //             ->hidden(!$this->payment->network), // Hide if network is null

        //         // Withdrawal status select
        //         Select::make('payment.withdrawal_status')
        //             ->title('Update Withdrawal Status')
        //             ->options([
        //                 'pending' => 'Pending',
        //                 'approved' => 'Approved',
        //                 'failed' => 'Failed',
        //             ])
        //             ->required(),

        //         Button::make('Update Withdrawal')
        //             ->method('updateWithdrawal')
        //             ->icon('check'),
        //     ])
        // ];

        return [
            Layout::rows(array_filter([ // Use array_filter to remove null values
                // User ID
                $this->payment->user_id ? Input::make('payment.user_id')
                    ->title('User ID')
                    ->readonly() : null,

                // Transaction Reference
                $this->payment->transaction_reference ? Input::make('payment.transaction_reference')
                    ->title('Transaction Reference')
                    ->readonly() : null,

                // Amount
                $this->payment->amount ? Input::make('payment.amount')
                    ->title('Amount')
                    ->readonly() : null,

                // Current Withdrawal Status
                $this->payment->withdrawal_status ? Input::make('payment.withdrawal_status')
                    ->title('Current Withdrawal Status')
                    ->readonly() : null,

                // Bank Name
                $this->payment->bank_name ? Input::make('payment.bank_name')
                    ->title('Bank Name')
                    ->readonly() : null,

                // Account Name
                $this->payment->account_name ? Input::make('payment.account_name')
                    ->title('Account Name')
                    ->readonly() : null,

                // Account Number
                $this->payment->account_number ? Input::make('payment.account_number')
                    ->title('Account Number')
                    ->readonly() : null,

                // Wallet Address
                $this->payment->wallet_address ? Input::make('payment.wallet_address')
                    ->title('Wallet Address')
                    ->readonly() : null,

                // Network
                $this->payment->network ? Input::make('payment.network')
                    ->title('Network')
                    ->readonly() : null,

                Select::make('payment.withdrawal_status')
                            ->title('Update Withdrawal Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'failed' => 'Failed',
                            ])
                            ->required(),

                        Button::make('Update Withdrawal')
                            ->method('updateWithdrawal')
                            ->icon('check'),
            ]))
        ];
    }

    public function updateWithdrawal(Request $request)
{
    // Validate the incoming request
    $data = $request->validate([
        'payment.withdrawal_status' => 'required',
        'payment.transaction_reference' => 'required',
    ]);

    $paymentStatus = $data['payment']['withdrawal_status'];
        $transactionReference = $data['payment']['transaction_reference'];

        $payment = Withdrawal::with('user')->where('transaction_reference', $transactionReference)->first();

        if ($paymentStatus == 'approved' && $payment->withdrawal_status == 'approved') {
            return redirect()->route('platform.withdrawal')->with('message', 'Transaction already has an existing withdrawal status of approved therefore withdrawal status is left unchanged.');
        }


        DB::transaction(function () use ($payment, $paymentStatus, $transactionReference) {

            if($paymentStatus == 'approved') {
                $payment->update(['withdrawal_status' => 'approved']);
            } elseif ($paymentStatus == 'pending') {
                $payment->update(['withdrawal_status' => 'pending']);
            } elseif ($paymentStatus == 'failed') {
                $payment->update(['withdrawal_status' => 'failed']);
            }

            $message = 'Withdrawal with transaction ref: ' . $transactionReference . '  ' . $paymentStatus;

                $payment->user->notify(

                    DashboardMessage::make()->title('Trx Notification')->message($message)->type(Color::INFO)
                );



        });

    // dd($data);

    // Find the withdrawal record by ID
    // $withdrawal = Withdrawal::findOrFail($id);

    // Update the withdrawal status
    // $withdrawal->update($data);

    // Redirect back with a success message
    Alert::success('Withdrawal status updated successfully.');

    return redirect()->route('platform.withdrawal'); // Replace with your actual route
}
}
