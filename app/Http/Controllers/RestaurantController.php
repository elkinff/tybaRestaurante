<?php

namespace App\Http\Controllers;

use App\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{

    /**
     * Get a validator for an get restaurants request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       return Validator::make($data, [
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request) {
        $requestValues = $request->all();
        $validator = $this->validator($requestValues);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return Restaurant::getRestaurantsByCoordinates($requestValues);
    }
}
