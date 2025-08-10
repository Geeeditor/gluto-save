<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\ActivateDashboard;
use App\Models\PackageSubscription;
use App\Models\Payments;
use App\Models\User;
use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'users' => count(User::all()), // Fetch all users
            'dashboards' => count(ActivateDashboard::where('dashboard_status', true)->get()),
            'paymentProcessed' => count(Payments::where('payment_status', 'approved')->get()),
            'activeSubscriptions' => count(PackageSubscription::where('package_status', 'active')->get())

        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    // public function name(): ?string
    // {
    //     return '';
    // }

    // /**
    //  * Display header description.
    //  */
    // public function description(): ?string
    // {
    //     return '';
    // }

    // /**
    //  * The screen's action buttons.
    //  *
    //  * @return \Orchid\Screen\Action[]
    //  */
    // public function commandBar(): iterable
    // {
    //     return [];
    // }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::view('platform::components.dashboard')

        ];
    }
}
