<?php
// namespace App\Livewire;

namespace App\Livewire;

use Livewire\Component;
use App\Models\ActivateDashboard;

class ManageDashboard extends Component
{
    public $dashboard; // Property to hold the dashboard data
    public $amount; // Property for the wallet balance input
    public $action; // Property for the action (add/deduct)
    public $status; // Property for the dashboard status
    public $isLoadingWallet = false; // Loading state for wallet update
    public $isLoadingStatus = false; // Loading state for status
    // update

    // protected $listeners = ['updateWallet'];

    public function mount($dashboard)
    {
        $this->dashboard = $dashboard; // Assign the dashboard data
        $this->status = $dashboard->status; // Set initial status
    }

    public function updateWallet()
    {
        $this->isLoadingWallet = true; // Set loading state to true

        $this->validate([
            'amount' => 'required|numeric|min:0',
            'action' => 'required|in:add,deduct',
        ]);

        // Fetch the dashboard record again to ensure data is fresh
        $dashboard = ActivateDashboard::find($this->dashboard->id);

        if ($dashboard) {
            if ($this->action === 'add') {
                $dashboard->wallet_balance += $this->amount;
            } elseif ($this->action === 'deduct') {
                $dashboard->wallet_balance -= $this->amount;
            }

            $dashboard->save();
            $this->dashboard = $dashboard; // Update the local dashboard property
            session()->flash('message', 'Wallet balance updated successfully!');
        } else {
            session()->flash('error', 'Dashboard not found.');
            $this->isLoadingWallet = false; // Reset loading state
            $this->reset(['amount', 'action']);
        }

        $this->isLoadingWallet = false; // Reset loading state
        $this->reset(['amount', 'action']); // Reset form fields
    }

    public function updateStatus()
    {
        $this->isLoadingStatus = true; // Set loading state to true

        $this->validate([
            'status' => 'required|boolean',
        ]);

        // Fetch the dashboard record again to ensure data is fresh
        $dashboard = ActivateDashboard::find($this->dashboard->id);

        if ($dashboard) {
            $dashboard->dashboard_status = $this->status;
            $dashboard->save();
            $this->dashboard = $dashboard; // Update the local dashboard property
            session()->flash('message', 'Dashboard status updated successfully!');
        } else {
            session()->flash('error', 'Dashboard not found.');
        $this->isLoadingStatus = false; // Reset loading state

        }

        $this->isLoadingStatus = false; // Reset loading state
    }

    public function render()
    {
        return view('livewire.manage-dashboard');
    }
}
