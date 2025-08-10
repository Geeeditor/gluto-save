<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\ActivateDashboard;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ManageUserDashboard extends Screen
{
    protected $dashboardId;


    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */

    protected $dashboard;

    public function query(int $id): iterable
    {
        $this->dashboard = ActivateDashboard::with('user')->find($id);

        if (!$this->dashboard) {
            Alert::warning("Dashboard not found.");
            return [];
        }

        // dd($this->dashboard);

        return [
            'dashboard' => $this->dashboard,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Manage Customer\'s Dashboard';
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
            Layout::view('platform::components.manage-user-dashboard', [
                'dashboard' => $this->dashboard, // Pass the dashboard data
            ])

        ];
    }
}
