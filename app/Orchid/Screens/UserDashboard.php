<?php

namespace App\Orchid\Screens;

use Orchid\Screen\TD;
use App\Models\Payment;
use App\Models\Payments;
use Orchid\Screen\Action;
// use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Table;
use App\Models\ActivateDashboard;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Platform\Notifications\DashboardMessage;

class UserDashboard extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $dashboards = ActivateDashboard::with('user')->get()->map(function ($dashboard) {

            return new Repository($dashboard->toArray());
        });

        // dd($dashboards);

        return [
            'dashboards' => $dashboards,
            'metric' => [
                'total_dashboards' => ActivateDashboard::count(),
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'User Dashboard';
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
     * Update the dashboard status based on conditions.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        // dd('hello');

        $dashboard = ActivateDashboard::findOrFail($id);

        $userId = $dashboard->user_id;


        // Check if the payment exists with the conditions
        $payment = Payments::where('user_id', $userId)
            ->where('payment_type', 'registration')
            ->where('payment_status', 'approved')
            ->first();

        if ($payment) {
            // Toggle the dashboard_status
            $dashboard->dashboard_status = !$dashboard->dashboard_status;
            $dashboard->save();
            $dashboard->user->notify(DashboardMessage::make()
                ->title(title: 'Dashboard Status Update')
                ->message('Your dashboard has been activated')
                ->type(Color::INFO));
            Alert::success('Dashboard status updated successfully.');
        } else {
            Alert::warning('Please confirm the registration payment before updating the dashboard status.');
        }

        return redirect()->route('platform.user-dashboard'); // Redirect back to the dashboard
    }


    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('dashboards', [
                TD::make('id', 'ID')->width('20'),
                TD::make('user.name', 'User ID')->width('100px'),
                TD::make('wallet_balance', 'Wallet Balance')->width('100px'),
                TD::make('dashboard_status', 'Dashboard Status')->render(function ($dashboard) {
                    return $dashboard['dashboard_status'] ? 'Active' : 'Inactive';
                }),
                TD::make('actions', 'Actions')->render(function ($dashboard) {
                    return Button::make('Toggle Status')
                        ->method('updateStatus', ['id' => $dashboard['id']]);
                }),
            ])
        ];
    }



}
