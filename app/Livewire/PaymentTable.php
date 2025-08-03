<?php

namespace App\Livewire;

use App\Models\Payments;
use Livewire\Component;

class PaymentTable extends Component
{
    public $trxRef = '';
    public $results;

    public function mount()
    {
        $this->results = Payments::with('user')->get(); // Load all payments initially
    }

    public function search()
    {
        $this->results = Payments::with('user')
            ->where('transaction_reference', 'like', '%' . $this->trxRef . '%')
            ->get();

        if ($this->results->isEmpty()) {
            session()->flash('message', 'Transaction not found');
        }
    }

    public function render()
    {

        $this->results = Payments::with('user')
            ->where('transaction_reference', 'like', '%' . $this->trxRef . '%')
            ->get();

        return view('livewire.payment-table', [
            'paymentData' => $this->results,
        ]);
    }
}
