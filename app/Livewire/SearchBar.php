<?php

namespace App\Livewire;

// use Faker\Provider\ar_EG\Payment;
use User;
use Livewire\Component;
use App\Models\Payments;

class SearchBar extends Component
{
    public $trx = '';

    public function render()
    {
        $results = [];

        if(strlen($this->trx) >=1){
            $results = Payments::where('transaction_reference', 'like', '%' . $this->trx)->limit(1)->get();
        }

        return view('livewire.search-bar', ['results' => $results]);
    }
}
