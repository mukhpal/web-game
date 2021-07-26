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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('api/eventdetail/{encryptedId}', 'Api\ApiController@eventDetails');

Route::get('/test', function () {
    return response('Great 123', 200)->header('Content-Type', 'application/json');
});

Route::group(['prefix' => 'v1'], function(){
	
	Route::get('/eventdetail/{encryptedId}', 'Api\ApiController@eventDetails');
	Route::post('/production', 'Api\ApiController@userProduction');
	Route::post('/roundresult', 'Api\ApiController@getRoundResult');

	Route::post('/rounddetails/{encryptedId}', 'Api\ApiController@roundDetails');
	Route::get('/validate_jwt_token/{token}', 'Api\ApiController@validateJWTToken');

	//forecasting API
	Route::post('/getforecasting', 'Api\ApiController@getForecastingDetails');

	//cron job
	Route::get('/crontasks', 'Api\ApiController@cronTasks');
	Route::get('/crontasks_ff', 'Api\ApiController@removeFunFactsCron');

	Route::get('/customresult/{eventId}', 'Api\ApiController@publishGameResult');
	Route::post('/survey', 'Api\ApiController@saveSurvey');
});

