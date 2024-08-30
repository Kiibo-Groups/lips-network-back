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

Route::group(array('namespace' => 'Api'), function () {

    /**
     * Datos iniciales
     */
    Route::get('getDataInit', 'ApiController@getDataInit');
    Route::get('homepage', 'ApiController@homepage');

    /**
     * Registro de sesion / Login
     */
    Route::post('login', 'ApiController@login');
    Route::post('signup', 'ApiController@signup');
    Route::post('sendOTP', 'ApiController@sendOTP');

    /**
     * Validacion de usuario
     */
    Route::post('chkUser', 'ApiController@chkUser');

    /**
     * Recuperacion de cuenta
     */
    Route::post('forgot', 'ApiController@forgot');
    Route::post('verify', 'ApiController@verify');
    Route::post('updatePassword', 'ApiController@updatePassword');

    Route::get('userinfo/{id}', 'ApiController@userinfo');
    Route::post('updateInfo/{id}', 'ApiController@updateInfo');


    /**
     * Favorites
     */
    Route::post('SetFavorite', 'ApiController@SetFavorite');
    Route::get('GetFavorites/{id}', 'ApiController@GetFavorites');
    Route::get('TrashFavorite/{id}/{user}', 'ApiController@TrashFavorite');

    /**
     * Tickets
     */
    Route::post('uploadTicket', 'ApiController@UploadTicket');
    Route::get('getLastTicket/{id}', 'ApiController@GetLastTicket');
    Route::get('getAllTickets/{id}','ApiController@GetAllTickets');

    /**
     * Rewards
     */
    Route::get('getMyRewards/{id}', 'ApiController@GetMyRewards');
    route::get('overview/{id}', 'ApiController@overview');


    Route::get('getListLeaders','ApiController@GetListLeaders');

    Route::post('requestWithdrawal','ApiController@RequestWithdrawal');
});
