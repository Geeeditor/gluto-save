<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

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
            'users' => User::all(), // Fetch all users
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Admin Dashboard';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Welcome, Manage Users Action With Application Settings Seemlessly.';
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
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            // Layout::view('platform::partials.update-assets'),
            // Layout::view('platform::partials.welcome'),

            Layout::table('users', [
                TD::make('id', 'ID')->width('100'),
                TD::make('name', 'Name'),
                TD::make('email', 'Email'),
                TD::make('created_at', 'Created At')->render(fn($user) => $user->created_at->format('Y-m-d H:i:s')),
            ]),
        ];
    }
}
