<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Restaurant extends Model
{

    /**
     * Get restaurants list request.
     *
     * @param  array  $requestValues  Get Latitude and Longitud values
     * @return \Illuminate\Http\Response
     */
    public static function getRestaurantsByCoordinates($requestValues) {
        $client = new Client();
        $transaction = new Transaction();

        $latitude = $requestValues['latitude'];
        $longitude = $requestValues['longitude'];

        $headersRequest = [
            'x-rapidapi-key' => config('app.api_restaurant_key'),
            'x-rapidapi-host' => config('app.api_restaurant_host'),
        ];

        $paramsRequest = [
            'location' => $latitude. ',' . $longitude,
            'radius' => '150',
            'type' => 'restaurant'
        ];
        
        try {
            $response = $client->request('GET', config('app.api_restaurant_url'), [
                'headers' => $headersRequest,
                'query' => $paramsRequest
            ]);
        } catch (RequestException $ex) {
            return response()->json(json_decode($ex->getResponse()->getBody()));
        }

        $transaction->saveTransaction('Get restaurants list by user: ' . Auth::user()->name);

        return response()->json(json_decode($response->getBody()));
    }
}
