<?php

namespace App\Livewire;

use App\Models\UserKyc;
use Livewire\Component;
use Orchid\Support\Color;
use App\Mail\KycApplication;
use Illuminate\Support\Facades\Mail;
use Orchid\Platform\Notifications\DashboardMessage;

class KycData extends Component
{
    public $kycRef = '';
    public $results;

    public $status = [];

    public function mount()
    {
        $this->results = UserKyc::with('user')->get(); // Load all payments initially
        $this->status = $this->results->pluck('application_status', 'id')->toArray(); // Initialize status array
    }

    public function updateStatus($id)
    {
        $kyc = UserKyc::with('user')->find($id);

        if ($kyc) {
            // Update the KYC application status
            $kyc->application_status = $this->status[$id];
            $kyc->save();

            $kycData = [
                'name' => $kyc->user->name,
                'email' => $kyc->user->email,
                'document_id' => $kyc->document_id,
                'document_type' => $kyc->document_type,
                'application_status' => $this->status[$id],
            ];

            try {

                Mail::to($kyc->user->email)->send(new KycApplication($kycData));

                // Mail::raw('This is a test email.', function ($message) {
                //     $message->to('alfredjoe@me.com')
                //         ->subject('Test Email');
                // });

                \Log::info('Test email sent successfully');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error sending test email: ' . $e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());
            }



            // Prepare the notification message
            $message = 'Dear ' . $kyc->user->name . ', ';
            $notificationType = Color::INFO; // Assuming Color::INFO is defined elsewhere

            switch ($this->status[$id]) {
                case 'pending_approval':
                    $message .= 'Your KYC application is still pending approval. Please hold on while we verify your information.';
                    break;
                case 'approved':
                    $message .= 'Your KYC application has been approved.';
                    $notificationType = Color::SUCCESS; // Change type for approval
                    break;
                case 'rejected':
                    $message .= 'Your KYC application was rejected. Please upload a clearer copy or contact support.';
                    $notificationType = Color::ERROR; // Change type for rejection
                    break;
                default:
                    $message .= 'Your KYC application status has been updated.';
            }

            // Notify the user
            $kyc->user->notify(
                DashboardMessage::make()
                    ->title('KYC Status')
                    ->message($message)
                    ->type($notificationType)
            );

            session()->flash('message', 'KYC status updated successfully.');
        } else {
            session()->flash('message', 'KYC record not found.');
        }
    }

    public function search()
    {
        $this->results = UserKyc::with('user')
            ->where('document_id', 'like', '%' . $this->kycRef . '%')
            ->get();

        if ($this->results->isEmpty()) {
            session()->flash('message', 'KYC record not found');
        }
    }



    public function render()
    {
        $this->results = UserKyc::with('user')->where('document_id', 'like', '%' . $this->kycRef . '%')
        ->get();

        return view('livewire.kyc-data', ['kycData' => $this->results]);
    }
}
