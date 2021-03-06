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
    Route::get('contact/{contact}', 'ApiControllers\ContactController@getContact');
    Route::put('contact/{contact}', 'ApiControllers\ContactController@updateContact');
    Route::delete('contact/{contact}', 'ApiControllers\ContactController@deleteContact');

    Route::post('add_user', 'ApiControllers\UserController@addUser');
    Route::post('update_user', 'ApiControllers\UserController@updateUser');

    Route::get('appointments', 'ApiControllers\AppointmentController@getAppointments');
    Route::get('appointment/{appointment}', 'ApiControllers\AppointmentController@getAppointment');
    Route::post('add_appointment', 'ApiControllers\AppointmentController@addAppointment');
    Route::put('appointment/{appointment}', 'ApiControllers\AppointmentController@updateAppointment');
    Route::delete('appointment/{appointment}', 'ApiControllers\AppointmentController@deleteAppointment');

    Route::post('logout', 'ApiControllers\LoginController@logout');

});
