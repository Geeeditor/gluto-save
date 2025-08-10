<?php

namespace App\Livewire;

use Livewire\Component;
use Orchid\Support\Color;
use App\Models\PackageSubscription;
use Orchid\Platform\Notifications\DashboardMessage;

class UserSubscription extends Component
{
    public $subRef = '';
    public $results;

    public $status = [];

    public function mount()
    {
        $this->results = PackageSubscription::with('user')->get(); // Load all payments initially
        $this->status = $this->results->pluck('package_status', 'id')->toArray(); // Initialize status array
    }

    public function updateStatus($id)
    {
        $sub = PackageSubscription::find($id);

        if ($sub) {
            // Update the KYC application status
            $sub->package_status = $this->status[$id];
            $sub->save();

            // Prepare the notification message
            $message = 'Dear ' . $sub->user->name . ', ';
            $notificationType = Color::INFO; // Assuming Color::INFO is defined elsewhere

            switch ($this->status[$id]) {
                case 'pending_approval':
                    $message .= 'Your subscription is still pending approval. Please hold on while we verify your information.';
                    break;
                case 'approved':
                    $message .= 'Your subscription has been approved.';
                    $notificationType = Color::SUCCESS; // Change type for approval
                    break;
                case 'rejected':
                    $message .= 'Your subscription was rejected. Please upload a clearer copy or contact support.';
                    $notificationType = Color::ERROR; // Change type for rejection
                    break;
                default:
                    $message .= 'Your KYC subscription status has been updated.';
            }

            // Notify the user
            $sub->user->notify(
                DashboardMessage::make()
                    ->title('KYC Status')
                    ->message($message)
                    ->type($notificationType)
            );

            session()->flash('message', 'Subscription status updated successfully.');
        } else {
            session()->flash('message', 'Subscription record not found.');
        }
    }

    public function search()
    {
        $this->results = PackageSubscription::with('user')
            ->where('sub_id', 'like', '%' . $this->subRef . '%')
            ->get();

        if ($this->results->isEmpty()) {
            session()->flash('message', 'Subscription record not found');
        }
    }



    public function render()
    {
        $this->results = PackageSubscription::with('user')
        ->where('sub_id', 'like', '%' . $this->subRef . '%')
        ->get();


        return view('livewire.user-subscription', ['subData' => $this->results]);
    }
}
