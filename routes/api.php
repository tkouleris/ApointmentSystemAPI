<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','ApiControllers\LoginController@login');

Route::group(['middleware' => ['jwt.auth']], function() {

    Route::get('contacts', 'ApiControllers\ContactController@getContacts');
    Route::post('add_contact', 'ApiControllers\ContactController@addContact');
    Route::post('contact/{contact}', 'ApiControllers\ContactController@getContact');

    Route::post('add_user', 'ApiControllers\UserController@addUser');

});
