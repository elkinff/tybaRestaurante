<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Transaction;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        return $validator;
    }

     /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = $this->validateLogin($request);

        if (!$validator->fails()) {
            if ($this->attemptLogin($request)) {
                $user = $this->guard()->user();
                $user->generateToken();
                
                $transaction = new Transaction();
                $transaction->saveTransaction('User: '.$user->name.' login.');
                
                return response()->json([
                    'data' => $user->toArray(),
                ]);
            }
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json(['errors' => $validator->errors()], 400);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $transaction = new Transaction();
        $user = Auth::user();
        
        if ($user) {
            $transaction->saveTransaction('User: ' .$user->name. ' logged out.');

            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.']);
    }
}
