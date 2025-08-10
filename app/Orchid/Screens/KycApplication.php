<?php

namespace App\Orchid\Screens;

use Orchid\Screen\TD;
use App\Models\UserKyc;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
// use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
// use Orchid\Screen\Layout;
use Orchid\Support\Facades\Layout;
use App\Models\Kyc; // Import your KYC model
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Repository; // Import Repository
use Orchid\Platform\Notifications\DashboardMessage;


class KycApplication extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */

    // The work mo
    public function query(): iterable
    {

        /* $kycApplications = UserKyc::with('user')->get()->map(function ($kyc) {
            return new Repository($kyc->toArray());
        });

        return [
            'kycApplications' => $kycApplications,
            'metric' => [
                'total_kyc' => UserKyc::count(),
            ]
        ]; */

        return [

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'KYC APPLICATIONS DATA PAGE';
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
           /*  Layout::metrics(
                ['Total KYC Applications' => 'metric.total_kyc']
            ), */

//             Layout::table('kycApplications', [
//                 TD::make('id', 'ID')->width('20'),
//                 TD::make('user.name', 'User Name')->width('150px'),
//                 TD::make('selfie_photo', 'Selfie Photo')->render(
//                     fn(Repository $kyc) => '<a href="' . asset('images/kyc/' . basename($kyc->get('selfie_photo'))) . '" target="_blank" style="
//     background-color: ; /* bg-blue-600 */
//     color: white; /* text-white */
//     padding: 0.5rem 1rem; /* px-4 py-2 */
//     font-weight: 500; /* font-medium */
//     transition: background-color 0.2s; /* transition duration-200 */
// " target="_blank" class="">
//                         🔗
//                     </a>'
//                 ),
//                 TD::make('document_type', 'Doc Type')->width('150px'),
//                 TD::make('document_front', 'Doc Front')->render(
//                     fn(Repository $kyc) => '<a href="' . asset('images/kyc/' . basename($kyc->get('document_front'))) . '" style="
//     background-color: ; /* bg-blue-600 */
//     color: white; /* text-white */
//     padding: 0.5rem 1rem; /* px-4 py-2 */
//     font-weight: 500; /* font-medium */
//     transition: background-color 0.2s; /* transition duration-200 */
// " target="_blank" class="">
//                         🔗
//                     </a>'
//                 ),
//                 TD::make('document_back', 'Doc Back')->render(
//                     fn(Repository $kyc) => '<a href="' . asset('images/kyc/' . basename($kyc->get('document_back'))) . '" target="_blank" style="
//     background-color: ; /* bg-blue-600 */
//     color: white; /* text-white */
//     padding: 0.5rem 1rem; /* px-4 py-2 */
//     font-weight: 500; /* font-medium */
//     transition: background-color 0.2s; /* transition duration-200 */
// " target="_blank" class="">
//                         🔗
//                     </a>'
//                 ),
//                 TD::make('document_id', 'Doc ID')->width('100px'),
//                 TD::make('application_status', 'Application Status')->width('150px'),



//                 TD::make('actions', 'Update Status')->render(
//                     function (Repository $kyc) {
//                         return Select::make('status_' . $kyc->get('id'))
//                             ->options([
//                                 'approved' => 'Approved',
//                                 'pending_approval' => 'Pending Approval',
//                                 'rejected' => 'Rejected'
//                             ])->width('120px')
//                             // ->default($kyc->get('application_status')) // Set default value

//                             . Button::make('Update')
//                                 ->method('updateKyc')
//                                 ->parameters(['id' => $kyc->get('id')]);
//                     }
//                 )

//                 // Layout::row([
//                 //     Select::make('test_select')
//                 //         ->options([
//                 //             'approved' => 'Approved',
//                 //             'pending_approval' => 'Pending Approval',
//                 //             'rejected' => 'Rejected'
//                 //         ])
//                 //         ->title('Test Select')
//                 // ])
//             ])

            Layout::view('platform::components.kyc')

        ];
    }

    // This method was migrated to a livewire class
    /* public function updateKyc(Request $request)
    {
        $kycId = $request->get('id');
        $status = $request->get('status_' . $kycId);

        // Ensure that the status is not null
        if (!$status) {
            Toast::error('Application status must be selected.');
            return redirect()->route('admin.kyc.list');
        }

        $kyc = UserKyc::find($kycId);

        if ($kyc) {
            // Update application_status and kyc_status
            $kyc->application_status = $status;
            $kyc->kyc_status = ($status === 'approved');
            $kyc->save();

            // Prepare notification message
            $message = 'Dear ' . $kyc->user->name . ', ';
            switch ($status) {
                case 'pending_approval':
                    $message .= 'Your KYC application is still pending approval. Please hold on while we verify your information.';
                    break;
                case 'approved':
                    $message .= 'Your KYC application has been approved.';
                    break;
                case 'rejected':
                    $message .= 'Your KYC application was rejected. Please upload a clearer copy or contact support.';
                    break;
                default:
                    $message .= 'Your KYC application status has been updated.';
            }

            // Send notification to the user
            $kyc->user->notify(
                DashboardMessage::make()
                    ->title('KYC Status')
                    ->message($message)
                    ->type(Color::INFO)
            );

            Toast::info('KYC status updated successfully.');
        } else {
            Toast::error('KYC application not found.');
        }

        return redirect()->back(); // Adjust the route name as needed
    } */
}
