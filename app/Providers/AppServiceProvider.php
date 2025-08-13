<?php

namespace App\Providers;

use App\Models\AppSetting;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\Notification as Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    protected $userService;

    // public function __construct(UserService $userService) {
    //     $this->userService = $userService;
    // } Wrong


    public function register(): void
    {
        // Bind UserService to the service container
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);

        View::composer('layouts.auth', function ($view) {
            $user = Auth::user();
            $userService = app(UserService::class);
            $settings = AppSetting::first() ;
            // dd($settings);
            $greeting = $userService->greetingText();
            $subscriptions = $user->subscriptions()->orderBy('is_primary', 'desc')->get() ?: []; //Same logic has currentSubscription
            // $subscriptions = $subscriptions->isEmpty() ? [] : $subscriptions;
            $currentSubscription = $user->subscriptions()->where('is_primary', true)->first() ?  $user->subscriptions()->where('is_primary', true)->first() : null ;




            // dd($subscriptions);




            if ($user) {
                $notifications = DB::table('notifications')->where('notifiable_id', $user->id)->get();
                $notificationData = [];

                foreach ($notifications as $notification) {
                    // Decode the entire 'data' field, which is a JSON string
                    $data = json_decode($notification->data, true); // No need for ['title'] here

                    if (isset($data['title'])) {
                        // $notificationData[] = $data;
                        $notificationData[] = $data['title'];
                    }
                }
            }
            // If no notifications, set to an empty array
            if (!isset($notificationData)) {
                $notificationData = [];
            }



            $view->with(['notificationData' => $notificationData, 'greeting' => $greeting, 'currentSubscription' => $currentSubscription, 'subscriptions' => $subscriptions, 'settings' => $settings ]);
        });
    }
}
