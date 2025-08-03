<?php

namespace App\Livewire;

use App\Models\Withdrawal;
use Livewire\Component;

class WithdrawalTable extends Component
{

    public $trxRef = '';
    public $results;

    public function mount()
    {
        $this->results = Withdrawal::with('user')->get(); // Load all payments initially
    }

    public function search()
    {
        $this->results = Withdrawal::with('user')
            ->where('transaction_reference', 'like', '%' . $this->trxRef . '%')
            ->get();

        if ($this->results->isEmpty()) {
            session()->flash('message', 'Transaction not found');
        }
    }
    public function render()
    {
        $this->results = Withdrawal::with('user')
            ->where('transaction_reference', 'like', '%' . $this->trxRef . '%')
            ->get();

        // dd($this->results);

        return view('livewire.withdrawal-table', [
            'withdrawals' => $this->results,
        ]);
    }
}
