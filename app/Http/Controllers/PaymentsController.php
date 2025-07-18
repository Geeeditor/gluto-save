<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class PaymentsController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        return view('dashboard.payment', ['user' => $user, 'profilePic' => $profilePic]);
    }

    public function retryPayment(Request $request, $id){
        $user = Auth::user();
        $profilePic = $this->userService->getUserPlaceholderImage();
        $transaction = $user->transactions()->where('id', $id)->first();

        // Expected value type
        // id
        // payment_type
        // transaction_reference

        if(!$transaction){
            return redirect()->back()->with('error','We could not find this transaction, please try again or contact support');
        }
        return view('dashboard.payment-retry', ['user' => $user, 'profilePic' => $profilePic]);
    }


}
