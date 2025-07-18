<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckDefaultedWeeks extends Command
{
    protected $signature = 'check:defaulted-weeks';
    protected $description = 'Check and update defaulted weeks for subscriptions';

    public function handle()
    {
        $subscriptions = PackageSubscription::all();

        foreach ($subscriptions as $subscription) {
            // Get the current week number of the year
            $currentWeek = Carbon::now()->weekOfYear;
            $currentYear = Carbon::now()->year;

            // Get contributions for this subscription
            $contributions = WeeklyContribution::where('subscription_id', $subscription->id)
                ->whereYear('contribution_date', $currentYear)
                ->where('contribution_date', '>=', Carbon::now()->startOfYear())
                ->pluck('contribution_date')
                ->map(function ($date) {
                    return Carbon::parse($date)->weekOfYear;
                });

            // Check for missed weeks
            for ($week = 1; $week <= 52; $week++) {
                if (!$contributions->contains($week)) {
                    // Increment defaulted weeks if no contribution was made
                    $subscription->increment('defaulted_weeks');
                }
            }
        }
    }
}
