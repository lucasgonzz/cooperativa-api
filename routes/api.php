<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {

    // Generals
    Route::post('search/{model_name}', 'SearchController@search');
    Route::post('previus-days/{model_name}', 'SearchController@search');
    Route::get('previus-day/{model_name}/{index}', 'CommonLaravel\PreviusDayController@previusDays');
    
    Route::get('user', 'UserController@user');
    Route::put('user/{id}', 'UserController@update');
    Route::put('user-password', 'UserController@updatePassword');

    Route::resource('partner', 'PartnerController');

    Route::resource('service', 'ServiceController');

    Route::resource('provider', 'ProviderController');

    Route::get('partner-payment/{model_id?}/{from_date}/{until_date?}', 'PartnerPaymentController@index');
    Route::resource('partner-payment', 'PartnerPaymentController');

    Route::get('provider-payment/{model_id}/{from_date}/{until_date}', 'ProviderPaymentController@index');
    Route::resource('provider-payment', 'ProviderPaymentController');

    // Images
    Route::post('set-image/{prop}', 'ImageController@setImage');
    Route::delete('delete-current-image/{model_name}/{id}/{prop_name?}', 'ImageController@deleteCurrentImage');

});
