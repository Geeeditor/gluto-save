<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function greetingText(){
        $currentHour = date('G'); // 0 to 23 format

        // Determine the greeting based on the hour
        // $greeting = '';

        if ($currentHour < 12) {
            $greeting = "Good Morning";
        } elseif ($currentHour < 18) {
            $greeting = "Good Afternoon";
        } else {
            $greeting = "Good evening";
        }

        return $greeting;
    }
    public function getUserPlaceholderImage()
    {
        $user = Auth::user();

        if ($user && $user->display_pic === null) {
            $usernames = $user->name; // Example input

            $displayImages = explode(" ", $usernames); // Split the string into an array

            // Select the first letter of each username
            $firstLettersArray = array_map(function ($username) {
                return strtoupper(substr($username, 0, 1)); // Get the first letter and convert to uppercase
            }, $displayImages);

            // Join the first letters into a string
            $firstLetters = implode('', $firstLettersArray);

            // Create the placeholder URL
            return 'https://placehold.co/300x300/000000/FFF?text=' . $firstLetters;
        }

        // Return a default image or null if the display picture exists
        return '/images/profiles/' .$user->display_pic; // or a default placeholder URL
    }

    public function generateTrxRef($trxType, $subID = null)
    {
        $transactionReference = '';

        if ($trxType == 'registration') {
            $transactionReference = 'ghep/reg/' . Str::random(5) . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'subscription') {
            if (is_null($subID)) {
                throw new \InvalidArgumentException("subID is required for subscription transactions.");
            }
            $transactionReference = 'ghep/sub/' . $subID . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'contribution') {
            if (is_null($subID)) {
                throw new \InvalidArgumentException("subID is required for contribution transactions.");
            }
            $transactionReference = 'ghep/wkpyt/' . $subID . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'debt_pyt') {
            if (is_null($subID)) {
                throw new \InvalidArgumentException("subID is required for owings transactions.");
            }
            $transactionReference = 'ghep/pkgowings/' . $subID . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'withdrawal') {
            $transactionReference = 'ghep/debit/' . Str::random(5) . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } elseif ($trxType == 'wallet_fund') {
            $transactionReference = 'ghep/credit/' . Str::random(5) . '/' . substr(time(), 6, 8) . '/' . Str::random(5);
        } else {
            throw new \InvalidArgumentException("Invalid payment type: $trxType");
        }

        return $transactionReference;
    }

    public function generateReceipt(){
        $randomCode = Str::random(10); // Generate a random 10-character code
        return 'gluto/hep/' . $randomCode;
    }

    public function generateAccount(User $users)
    {
        $existingNumbers = $users->subscriptions->pluck('sub_id')->toArray();

        if($existingNumbers == null) {
            $existingNumbers = ['12345678910', '10987654321'];
        }

        do {
            // Generate an 11-digit random number
            $accountNumber = str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
        } while (in_array($accountNumber, $existingNumbers));

        return $accountNumber;
    }
}
