<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Mail\Registration;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{

    private function generateAccount(User $user) {
        // Retrieve existing account IDs from subscriptions
        $existingNumbers = $user->subscriptions->pluck('account_id')->toArray();

        if($existingNumbers == null) {
            $existingNumbers = ['12345678910', '10987654321'];
        }

        do {
            // Generate an 11-digit random number
            $accountNumber = str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
        } while (in_array($accountNumber, $existingNumbers));

        return $accountNumber;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, User $user): RedirectResponse

    {
        // dd('heelo');
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'gender' => 'required',
            'contact_no' => 'required',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date|before:2007-01-01',
            'terms_condition' => 'required',
            'referral_id' => 'nullable|max:6|exists:users,referral_id',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]
        ,
            [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'gender.required' => 'The gender field is required',
                'contact_no.required' => 'You need to provide a valid contact information',
                'terms_condition.required' => 'You need to agree to our terms and conditions',
                'referral_id.required' => 'You need to provide a valid referral id that is 6 characters long',
                'dob' => 'You must be at least 18 years old to register.',
            ]
        );

        $referrer = User::where("referral_id", $request->referral_id)->first();


        // dd($referrer);
        if($data['referral_id'] == null  ) {
            $referral_code = Str::random(6);

            // Create the new user
            $authUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'dob' => $request->dob,
                'referral_id' => $referral_code,
                'password' => Hash::make($request->password),
            ]);


            // Trigger the event for the newly created user
            event(new Registered($authUser));

            $userData = [
                'name' => $authUser->name,
                'email' => $authUser->email,
                'referral_code' => $referral_code,
                'created_at' => $authUser->created_at,
            ];

            try {

                Mail::to($authUser->email)->send(new Registration($userData));

                // Mail::raw('This is a test email.', function ($message) {
                //     $message->to('alfredjoe@me.com')
                //         ->subject('Test Email');
                // });

                \Log::info('Test email sent successfully');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error sending test email: ' . $e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());

            }

            // Log in the newly created user
            Auth::login($authUser);

            // $name = $authUser->name;

            // try {
            //     Mail::to($request->email)->send(new SignUpConfirmation($name, $referral_code));
            // } catch (\Throwable $e) {
            //     return redirect()->back()->with('error', 'Our system is experiencing an error please try again later :( ');
            // }

            return redirect()->route('dashboard');
        }  elseif ($data['referral_id'] !== null && $referrer) {
              // Retrieve the user with the referral code
            $total_referred_users = $referrer->total_referred_users + 1;
            $referrer->update(['total_referred_users' => $total_referred_users]);

            $referral_code = Str::random(6);

            // Create the new user
            $authUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'dob' => $request->dob,
                'referral_id' => $referral_code,
                'password' => Hash::make($request->password),
            ]);

            $userData = [
                'name' => $authUser->name,
                'email' => $authUser->email,
                'referral_code' => $referral_code,
                'created_at' => $authUser->created_at,
            ];

            try {

                Mail::to($authUser->email)->send(new Registration($userData));

                // Mail::raw('This is a test email.', function ($message) {
                //     $message->to('alfredjoe@me.com')
                //         ->subject('Test Email');
                // });

                \Log::info('Test email sent successfully');
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error sending test email: ' . $e->getMessage());
                return redirect()->back()->with('error', $e->getMessage());

            }


            // Trigger the event for the newly created user
            event(new Registered($authUser));

            // Log in the newly created user
            Auth::login($authUser);



            // try {
            //     Mail::to($request->email)->send(new SignUpConfirmation($name, $referral_code));
            // } catch (\Throwable $e) {
            //     return redirect()->back()->with('error', 'Our system is experiencing an error please try again later :( ');
            // }

            return redirect()->route('dashboard');

        } elseif ($referrer == null || !$referrer) {
            return redirect()->back()->with('error', 'Invalid referral code provided!');
        }
    }
}
