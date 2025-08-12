<?php

namespace App\Livewire;

use App\Models\AppSetting;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Payments;
use App\Models\Withdrawal;

class Chart extends Component
{
    public $timeframe = 'All Time'; // Default timeframe
    public $paymentTypes = []; // Array to store payment type totals

    // registeration, walletFunding, subscription, contribution, debtPyt, withdrawals
    // public


    public function render()
    {
        $paymentsValues = [
            'registration' => [],
            'walletFunding' => [],
            'subscription' => [],
            'contribution' => [],
            'debtPyt' => [],
            'withdrawals' => []
        ];
        // Filter payments and withdrawals based on the selected timeframe
        $dateRange = $this->getDateRange($this->timeframe);

        // Base query for payments
        $paymentsQuery = Payments::with('user')->where('payment_status', 'approved');

        // Apply date filter only if a valid date range is provided
        if ($dateRange['start'] && $dateRange['end']) {
            $paymentsQuery->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }

        $payments = $paymentsQuery->get();

        // Base query for withdrawals
        $withdrawalsQuery = Withdrawal::with('user')->where('withdrawal_status', 'approved');

        // Apply date filter only if a valid date range is provided
        if ($dateRange['start'] && $dateRange['end']) {
            $withdrawalsQuery->whereBetween('created_at', [$dateRange['start'], $dateRange['end']]);
        }

        $withdrawals = $withdrawalsQuery->get();

        $nairaWithdrawal = $withdrawals->whereNotNull('account_name');

        $cryptoWithdrawal = $withdrawals->whereNotNull('crypto_option');

        $rate = AppSetting::first() ? AppSetting::first()->value('rate') : 0.00;

        $cryptoWithdrawalValue = [];

        $totalCryptoWithdrawal = 0;

        foreach ($cryptoWithdrawal as $crypto) {
            $convertedAmount = $crypto->amount * $rate;
            $cryptoWithdrawalValue[] = $convertedAmount;
            $totalCryptoWithdrawal += $convertedAmount;
        }

        $nairaWithdrawalValue = [];

        $totalNairaWithdrawal = 0;

        foreach ($nairaWithdrawal as $naira) {
            $nairaWithdrawal = $naira->amount;
            $nairaWithdrawalValue[] = $nairaWithdrawal;
            $totalNairaWithdrawal += $nairaWithdrawal;
        }

        // Calculate totals
        $totalPayments = $payments->sum('amount');
        $totalWithdrawals = $totalCryptoWithdrawal + $totalNairaWithdrawal;
        $grandTotal = $totalPayments + $totalWithdrawals;

        $withdrawalValues  = array_merge($cryptoWithdrawalValue, $nairaWithdrawalValue);

        foreach ($withdrawalValues as $withdrawal) {
            $withdrawalResults = $withdrawal;
            $paymentsValues['withdrawals'][] = $withdrawalResults;
        }


        // dd($withdrawalValues);

        // Process payment types
        $this->paymentTypes['registration'] = $payments->where('payment_type', 'registration');

        foreach ($this->paymentTypes['registration'] as $regPyt) {
            $registrationPayment = $regPyt->amount;
            $paymentsValues['registration'][] = $registrationPayment;
        }

        $this->paymentTypes['subscription'] = $payments->where('payment_type', 'subscription');

        foreach ($this->paymentTypes['subscription'] as $subPyt) {
            $subscriptionPayment = $subPyt->amount;
            $paymentsValues['subscription'][] = $subscriptionPayment;
        }

        $this->paymentTypes['contribution'] = $payments->where('payment_type', 'contribution');

        foreach ($this->paymentTypes['contribution'] as $contPyt) {
            $contributionPayment = $contPyt->amount;
            $paymentsValues['contribution'][] = $contributionPayment;
        }


        $this->paymentTypes['debt_pyt'] = $payments->where('payment_type', 'debt_pyt');

        foreach ($this->paymentTypes['debt_pyt'] as $debtPyt) {
            $debtPayment = $debtPyt->amount;
            $paymentsValues['debtPyt'][] = $debtPayment;
        }


        $this->paymentTypes['wallet_funding'] = $payments->where('payment_type', 'wallet_fund');

        foreach ($this->paymentTypes['wallet_funding'] as $fundingPyt) {
            $fundingPayment = $fundingPyt->amount;
            $paymentsValues['walletFunding'][] = $fundingPayment;
        }



        $this->paymentTypes['debt_pyt'] = $payments->where('payment_type', 'debt_pyt');

        foreach ($this->paymentTypes['debt_pyt'] as $debtPyt) {
            $debtPayment = $debtPyt->amount;
            $paymentsValues['debtPyt'][] = $debtPayment;
        }

        // $values = $this->paymentsValues;

        // $paymentRecords['withdrawals'] = array_merge($this->paymentsValues, $withdrawalValues);

        // dd($values);

        // $this->dispatchBrowserEvent('updateTimeframe');

        return view('livewire.chart', [
            'totalPayments' => $totalPayments,
            'totalWithdrawals' => $totalWithdrawals,
            'grandTotal' => $grandTotal,
            'paymentValues' => $paymentsValues,
            // 'paymentValues' =>
            // 'regsitration' => $this->paymentsValues['registration'],
            // 'subscription' => $this->paymentsValues['subscription'],
            // 'contribution' => $this->paymentsValues['contribution'],
            // 'debtPyt' => $this->paymentsValues['debtPyt'],
            // 'walletFunding' => $this->paymentsValues['walletFunding'],
            // 'withdrawalValues' => $withdrawalValues,

        ]);
    }

    // Function to get the start and end date based on the selected timeframe
    private function getDateRange($timeframe)
    {
        $end = Carbon::now();
        switch ($timeframe) {
            case 'Today':
                // Set both start and end to the current date
                return [
                    'start' => $end->copy()->startOfDay(),
                    'end' => $end->copy()->endOfDay(),
                ];
            case '1 month':
                $start = $end->copy()->subMonth();
                break;
            case '3 months':
                $start = $end->copy()->subMonths(3);
                break;
            case '6 months':
                $start = $end->copy()->subMonths(6);
                break;
            case '1 year':
                $start = $end->copy()->subYear();
                break;

            case 'All Time':
            default:
                // $start = Carbon::minValue(); // Earliest date in the database
                // return ['start' => null, 'end' => null];
                // break;
        }
        return ['start' => null, 'end' => null];

    }

    // Call this function when a user selects a new timeframe
    public function updateTimeframe($newTimeframe)
    {
        $this->timeframe = $newTimeframe;
        $this->render(); // Re-render with updated data
        // $this->emit('chartUpdated');
    }



}
