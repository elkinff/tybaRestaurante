<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;

class UserController extends Controller
{
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function crearPared()
    {
        $transaction = new Transaction();
        $transaction->crearPared();
        // dd(auth()->user());
        // dd(Auth::guard('api')->user());
        // // $transaction = new Transaction();
        // // $user = Auth::user();
        // dd($user);
        // dd($this->guard()->user());
        if ($user) {
            $transaction->saveTransaction('User: ' .$user->name. ' logged out.');

            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.']);
    }
}
