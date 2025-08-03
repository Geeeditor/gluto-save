<?php

namespace App\Orchid\Screens;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Orchid\Platform\Notifications\DashboardMessage;
use App\Models\PackageSubscription; // Import your PackageSubscription model

class UserSubscription extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $subscriptions = PackageSubscription::with('user')->get()->map(function ($subscription) {
            return new Repository($subscription->toArray());
        });

        return [
            'subscriptions' => $subscriptions,
            'metric' => [
                'total_subscriptions' => PackageSubscription::count(),
            ]
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'User Subscription';
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
            Layout::metrics(
                ['Total Subscriptions' => 'metric.total_subscriptions']
            ),

            Layout::table('subscriptions', [
                TD::make('id', 'ID'),
                TD::make('user.name', 'User ID'),
                TD::make('tier', 'Tier'),
                TD::make('total_contribution', 'Total Contribution'),
                TD::make('defaulted_weeks', 'Defaulted Weeks'),
                TD::make('package_status', 'Package Status'),
                TD::make('sub_id', 'Sub ID'),
                TD::make('sub_fee', 'Sub Fee'),

                TD::make('actions', 'Update Status')->render(function (Repository $subscription) {
                    return Select::make('status_' . $subscription->get('id'))
                        ->options([
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'matured' => 'Matured',
                            'terminated' => 'Terminated',
                            'pending_activation' => 'Pending Activation'
                        ])
                        ->default($subscription->get('package_status')) // Set default value
                        ->width('150px')
                        . Button::make('Update')
                            ->method('updateSubscription')
                            ->parameters(['id' => $subscription->get('id')]);
                }),
            ])
        ];
    }

    public function updateSubscription(Request $request)
    {
        // dd('fuck me');
        $subscriptionId = $request->get('id');
        $status = $request->get('status_' . $subscriptionId);

        // Ensure that the status is not null
        if (!$status) {
            Toast::error('Subscription status must be selected.');
            return redirect()->route('platform.subscriptions'); // Adjust the route name as needed
        }

        $subscription = PackageSubscription::find($subscriptionId);

        if ($subscription) {
            // Update package_status
            $subscription->package_status = $status;
            $subscription->save();


            // Prepare notification message
            $message = 'Dear ' . $subscription->user->name . ', ';
            switch ($status) {

                case 'active':
                    $message .= 'Your subscription package with id:' . $subscription->sub_id .' is now active.';
                    break;
                case 'inactive':
                    $message .= 'Your subscription package with id:' . $subscription->sub_id . ' is now inactive.';
                    break;

                case 'terminated':
                    $message .= 'Your subscription package with id:' . $subscription->sub_id . ' has been terminated.';
                    break;

                case 'mature':
                    $message .= 'Your subscription package with id:' . $subscription->sub_id . ' has matured and is ready to be claimed.';
                    break;
                default:
                    $message .= 'Your KYC application status has been updated.';
            }

            // Send notification to the user
            $subscription->user->notify(
                DashboardMessage::make()
                    ->title('Subscription')
                    ->message($message)
                    ->type(Color::INFO)
            );

            Toast::info('Subscription status updated successfully.');
        } else {
            Toast::error('Subscription not found.');
        }

        return redirect()->back(); // Adjust the route name as needed
    }
}
