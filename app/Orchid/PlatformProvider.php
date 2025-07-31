<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Dashboard')
                ->icon('bs.window-dock')
                ->route('platform.main')
                ->title('Navigation'),

            Menu::make('Manage Payments')
                ->icon('bs.wallet')
                ->route('platform.payments')
                ->divider(),

                // ->route('platform.payments.view'),

            // Menu::make('Update Payments')
            //     ->icon('bs.pencil')
            //     // ->route('platform.payments.update')


            Menu::make('Manage KYC Application')
                ->icon('bs.file-earmark-check')
                ->route('platform.kyc.list')
                ->divider(),

            // Menu::make('Update KYC Applications')
            //     ->icon('bs.check-circle')
            //     // ->route('platform.kyc.update')
            //     ->divider(),

            Menu::make('Manage User Dashboard')
                ->icon('bs.person-lines-fill')
                ->route('platform.user-dashboard')
                ->divider(),

            // Menu::make('Update User Dashboard Status')
            //     ->icon('bs.graph-up')
            //     // ->route('platform.dashboard.update')
            //     ->divider(),

            Menu::make('Manage Subscriptions')
                ->icon('bs.card-list')
                ->route('platform.user-subscription')
                ->divider(),

            // Menu::make('Update Subscription Data')
            //     ->icon('bs.card-checklist')
            //     // ->route('platform.subscriptions.update')
            //     ->divider(),

            Menu::make('Manage Withdrawal ')
                ->icon('bs.arrow-left-right'),
            // ->route('platform.withdrawals.view')

            Menu::make('App Settings')
                ->icon('bs.gear')
                ->route('platform.settings')
                ->divider(),




        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
