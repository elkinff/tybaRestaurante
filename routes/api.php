<?php
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('restaurants', 'RestaurantController@index');
    Route::get('transactions', 'TransactionController@index');
    Route::post('logout', 'Auth\LoginController@logout');
});

Route::post('register', 'Auth\RegisterController@register');

Route::post('login', 'Auth\LoginController@login');



