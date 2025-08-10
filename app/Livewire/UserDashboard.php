<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserDashboard extends Component
{

    public $name = '';
    public $results;

    public function mount()
    {
        $this->results = User::with('activeDashboard')->get(); // Load all payments initially
    }

    public function search()
    {
        $this->results = User::with('activeDashboard')
            ->where('name', 'like', '%' . $this->name . '%')
            ->get();

        if ($this->results->isEmpty()) {
            session()->flash('message', 'Transaction not found');
        }
    }

    public function render()
    {
        $this->results = User::with('activeDashboard')
            ->where('name', 'like', '%' . $this->name . '%')
            ->get();
            // dd($this->results);

        return view('livewire.user-dashboard', ['users' => $this->results]);
    }
    // public function render()
    // {
    //     return view('livewire.user-dashboard');
    // }
}
