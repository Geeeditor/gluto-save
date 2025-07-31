<?php

namespace App\Orchid\Screens;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Repository;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use App\Models\AppSetting; // Import your AppSetting model

class AppSettings extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        // Fetch the first AppSetting record
        $appSettings = AppSetting::first();

        return [
            'appSettings' => $appSettings,
            'metric' => [
                'total_app_settings' => AppSetting::count(),
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
        return 'App Settings';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            // Button::make('Save')
            //     ->method('save')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $appSettings = $this->query()['appSettings'];

        return [
            Layout::rows([
                Select::make('appSetting.withdrawal_enabled')
                    ->title('Enable Withdrawal')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->value($appSettings->withdrawal_enabled)
                    ->empty('Select an option'),

                    Select::make('appSetting.contribution_enabled')
                    ->title('Enable Contribution')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->value($appSettings->contribution_enabled)
                    ->empty('Select an option'),

                Select::make('appSetting.subscription_enabled')
                    ->title('Enable Subscription')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->value($appSettings->subscription_enabled)
                    ->empty('Select an option'),

                Button::make('Update Settings')
                    ->method('save')
                    ->icon('check'),

                Link::make('Go to Configuration')
                    ->route('platform.config.update')
                    ->icon('cog'),
            ])
        ];
    }

    /**
     * Save the app settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $data = $request->validate([
            'appSetting.withdrawal_enabled' => 'required|boolean',
            'appSetting.contribution_enabled' => 'required|boolean',
            'appSetting.subscription_enabled' => 'required|boolean',
            // Include other fields as needed
        ]);

        // Update the AppSetting record
        $appSettings = AppSetting::first();
        $appSettings->update($data['appSetting']);

        Toast::info('App settings updated successfully.');

        return redirect()->route('platform.settings'); // Adjust the route as necessary
    }
}
