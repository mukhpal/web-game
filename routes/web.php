<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'/*,  'middleware' => 'auth'*/], function(){

	// Admin Authenticate & Forgot Password Routes
	Route::get('/login', ['as' => 'admin.login', 'uses' => 'Admin\LoginController@loginForm']);
	Route::post('/authenticate', ['as' => 'admin.authenticate', 'uses' => 'Admin\LoginController@authenticate']);
	Route::post('/admin_forgot_password', ['as' => 'admin.forgot_password', 'uses' => 'Admin\LoginController@admin_forgot_password']);
	Route::get('/resetPassword/{token}', ['as' => 'admin.resetpassword', 'uses' => 'Admin\LoginController@showResetPassword']);
	Route::post('/updatePassword', ['as' => 'admin.update_password', 'uses' => 'Admin\LoginController@updatePassword']);


	Route::get('/', function () { return redirect()->action('Admin\LoginController@loginForm'); });

	// Users CRUD
	Route::match(['get', 'post'],'/users', ['as' => 'admin.userlist', 'uses' => 'Admin\UsersController@userListing']);
	Route::get('/adduser', ['as' => 'admin.adduser', 'uses' => 'Admin\UsersController@addUser']);
	Route::get('/loadstates/{countryId}/{stateId}', ['as' => 'admin.loadstates', 'uses' => 'Admin\AdminController@loadStates']);
	Route::post('/saveuser', ['as' => 'admin.saveuser', 'uses' => 'Admin\UsersController@saveUser']);
	Route::get('/userajaxdata', ['as' => 'admin.userajaxdata', 'uses' => 'Admin\UsersController@ajaxDataLoad']);
	Route::get('/edituser/{id}', ['as' => 'admin.edituser', 'uses' => 'Admin\UsersController@editUser']);
	Route::post('/updateuser', ['as' => 'admin.updateuser', 'uses' => 'Admin\UsersController@updateUser']);

	//Event managers CRUD operations
	Route::match(['get', 'post'],'/eventmanagers', ['as' => 'admin.eventmanagerlist', 'uses' => 'Admin\EventManagersController@eventManagerListing']);
	Route::get('/addeventmanager', ['as' => 'admin.addeventmanager', 'uses' => 'Admin\EventManagersController@addEventManager']);
	Route::post('/saveeventmanager', ['as' => 'admin.saveeventmanager', 'uses' => 'Admin\EventManagersController@saveEventManager']);
	Route::get('/eventmanagerajaxdata', ['as' => 'admin.eventmanagerajaxdata', 'uses' => 'Admin\EventManagersController@ajaxDataLoad']);
	Route::get('/editeventmanager/{id}', ['as' => 'admin.editeventmanager', 'uses' => 'Admin\EventManagersController@editEventManager']);
	Route::post('/updateeventmanager', ['as' => 'admin.updateeventmanager', 'uses' => 'Admin\EventManagersController@updateEventManager']);

	Route::post('/event/manager/approval', ['as' => 'admin.approve_event_manager', 'uses' => 'Admin\EventManagersController@approveEventManageAccount']);

	// Events CRUD
	Route::match(['get', 'post'],'/events', ['as' => 'admin.eventlist', 'uses' => 'Admin\EventsController@eventListing']);
	Route::get('/addevent', ['as' => 'admin.addevent', 'uses' => 'Admin\EventsController@addEvent']);
	/*Route::post('/saveevent', ['as' => 'admin.saveevent', 'uses' => 'Admin\EventsController@saveEvent']);*/
	Route::get('/eventajaxdata', ['as' => 'admin.eventajaxdata', 'uses' => 'Admin\EventsController@ajaxDataLoad']);
	Route::get('/eventdetails/{id}', ['as' => 'admin.eventdetails', 'uses' => 'Admin\EventsController@eventDetails']);

	Route::get('/eventajaxmembers/{id}', ['as' => 'admin.eventajaxmembers', 'uses' => 'Admin\EventsController@ajaxEventMembers']);

	//Admin Profile Routes
	Route::get('/profile', ['as' => 'admin.profile', 'uses' => 'Admin\ProfileController@adminprofile']);
	Route::post('/profileupdate', ['as' => 'admin.profileupdate', 'uses' => 'Admin\ProfileController@profileupdate']);
	Route::post('/updatepassword', ['as' => 'admin.updatepassword', 'uses' => 'Admin\ProfileController@updatepassword']);
	Route::get('/settings', ['as' => 'admin.settings', 'uses' => 'Admin\GameSettingsController@settings']);
	Route::post('/settingsupdate', ['as' => 'admin.settingsupdate', 'uses' => 'Admin\GameSettingsController@settingsUpdate']);

	//Single & Bulk Delete Routes
	Route::post('/deleterow', ['as' => 'admin.deleterow', 'uses' => 'Admin\CommonController@deleteRow']);
	Route::post('/updatebulkrows', ['as' => 'admin.updatebulkrows', 'uses' => 'Admin\CommonController@updateBulkRows']);
	Route::post('/setactiveinactive', ['as' => 'admin.setactiveinactive', 'uses' => 'Admin\CommonController@setActiveInactive']);

	//Dashboard
	Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'Admin\DashboardController@dashboard']);
	Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'Admin\LoginController@logout']);

	//Survey 
	Route::match(['get', 'post'],'/survey', ['as' => 'admin.surveylist', 'uses' => 'Admin\SurveyController@surveyListing']);
	Route::get('/surveyajaxdata', ['as' => 'admin.surveyajaxdata', 'uses' => 'Admin\SurveyController@ajaxDataLoad']);

	//crops management routes 
	Route::match(['get', 'post'],'/crops', ['as' => 'admin.cropslist', 'uses' => 'Admin\CropsController@cropsListing']);

	Route::get('/addcrop', ['as' => 'admin.addcrop', 'uses' => 'Admin\CropsController@addCrop']);

	Route::post('/savecrop', ['as' => 'admin.savecrop', 'uses' => 'Admin\CropsController@saveCrop']);

	Route::get('/cropajaxdata', ['as' => 'admin.cropajaxdata', 'uses' => 'Admin\CropsController@ajaxDataLoad']);

	Route::get('/editcrop/{id}', ['as' =>'admin.editcrop', 'uses' => 'Admin\CropsController@editCrop']);

	Route::post('/updatecrop', ['as' => 'admin.updatecrop', 'uses' => 'Admin\CropsController@updateCrop']);
	//crops management routes 

	// CMS CRUD
		//Pages CRUD
		Route::get('/pages', ['as' => 'admin.pages', 'uses' => 'Admin\PagesController@index']);
		Route::post('/pages/list', ['as' => 'admin.pages_list', 'uses' => 'Admin\PagesController@list']);
		Route::get('/page/edit/{key}', ['as' => 'admin.edit_page', 'uses' => 'Admin\PagesController@edit']);
		Route::post('/page/update/{key}', ['as' => 'admin.update_page', 'uses' => 'Admin\PagesController@update']);
		
		//FAQS CRUD
		Route::get('/faqs', ['as' => 'admin.faqs', 'uses' => 'Admin\FAQSController@index']);
		Route::post('/faq/list', ['as' => 'admin.faqs_list', 'uses' => 'Admin\FAQSController@list']);
		Route::get('/faq/create/', ['as' => 'admin.create_faq', 'uses' => 'Admin\FAQSController@create']);
		Route::post('/faq/add/', ['as' => 'admin.add_faq', 'uses' => 'Admin\FAQSController@add']);
		Route::get('/faq/edit/{id}', ['as' => 'admin.edit_faq', 'uses' => 'Admin\FAQSController@edit']);
		Route::post('/faq/update/{id}', ['as' => 'admin.update_faq', 'uses' => 'Admin\FAQSController@update']);
		Route::post('/faq/delete/', ['as' => 'admin.delete_faq', 'uses' => 'Admin\FAQSController@delete']);
		Route::post('/faq/reorder/', ['as' => 'admin.reorder_faq', 'uses' => 'Admin\FAQSController@reorder']);
		
		//Packages CRUD
		Route::get('/packages', ['as' => 'admin.packages', 'uses' => 'Admin\PackagesController@index']);
		Route::post('/package/list', ['as' => 'admin.packages_list', 'uses' => 'Admin\PackagesController@list']);
		Route::get('/package/create/', ['as' => 'admin.create_package', 'uses' => 'Admin\PackagesController@create']);
		Route::post('/package/add/', ['as' => 'admin.add_package', 'uses' => 'Admin\PackagesController@add']);
		Route::get('/package/edit/{id}', ['as' => 'admin.edit_package', 'uses' => 'Admin\PackagesController@edit']);
		Route::post('/package/update/{id}', ['as' => 'admin.update_package', 'uses' => 'Admin\PackagesController@update']);
		Route::post('/package/delete/', ['as' => 'admin.delete_package', 'uses' => 'Admin\PackagesController@delete']);
		Route::post('/package/reorder/', ['as' => 'admin.reorder_package', 'uses' => 'Admin\PackagesController@reorder']);
		
		//Conf content CRUD
		Route::get('/configrations/edit', ['as' => 'admin.edit_content_configuration', 'uses' => 'Admin\ContentConfigurationsController@edit']);
		Route::post('/content/configrations/update', ['as' => 'admin.update_cc', 'uses' => 'Admin\ContentConfigurationsController@update']);

		//Games CRUD
		Route::get('/games', ['as' => 'admin.games', 'uses' => 'Admin\GamesController@index']);
		Route::post('/games/list', ['as' => 'admin.games_list', 'uses' => 'Admin\GamesController@list']);
		Route::get('/game/edit/{key}', ['as' => 'admin.edit_game', 'uses' => 'Admin\GamesController@edit']);
		Route::post('/game/update/{key}', ['as' => 'admin.update_game', 'uses' => 'Admin\GamesController@update']);

		//Template CRUD
		Route::get('/others', ['as' => 'admin.others', 'uses' => 'Admin\OthersController@index']);
		Route::get('/callouts', ['as' => 'admin.callouts', 'uses' => 'Admin\OthersController@callouts']);
		Route::post('/callouts/update_callout', ['as' => 'admin.update_callout', 'uses' => 'Admin\OthersController@updateCallout']);

});

Route::group(['prefix' => 'event_manager'], function(){
	
	// Admin Authenticate & Forgot Password Routes
	Route::get('/login', ['as' => 'eventmanager.login', 'uses' => 'EventManager\LoginController@loginForm']);
	Route::post('/authenticate', ['as' => 'eventmanager.authenticate', 'uses' => 'EventManager\LoginController@authenticate']);
	Route::get('/signup', ['as' => 'eventmanager.signup', 'uses' => 'EventManager\EventManagerController@signupForm']);
	Route::post('/register', ['as' => 'eventmanager.register', 'uses' => 'EventManager\EventManagerController@register']);
	Route::post('/forgotPassword', ['as' => 'eventmanager.forgot_password', 'uses' => 'EventManager\LoginController@forgotPassword']);
	Route::get('/resetPassword/{token}', ['as' => 'eventmanager.resetpassword', 'uses' => 'EventManager\LoginController@resetPassword']);
	Route::post('/updateForgotPassword', ['as' => 'eventmanager.update_password', 'uses' => 'EventManager\LoginController@updateForgotPassword']);

	Route::get('/', function () { return redirect()->action('EventManager\LoginController@loginForm'); });


	Route::get('/accountVerify/{token}', ['as' => 'eventmanager.verifyaccount', 'uses' => 'EventManager\EventManagerController@verifyAccount']);
	

	//Admin Profile Routes
	Route::get('/profile', ['as' => 'eventmanager.profile', 'uses' => 'EventManager\ProfileController@profile']);
	Route::post('/profileupdate', ['as' => 'eventmanager.profileupdate', 'uses' => 'EventManager\ProfileController@profileupdate']);
	Route::post('/updatepassword', ['as' => 'eventmanager.updatepassword', 'uses' => 'EventManager\ProfileController@updatepassword']);

	Route::get('/dashboard', ['as' => 'eventmanager.dashboard', 'uses' => 'EventManager\DashboardController@dashboard']);

	Route::get('/eventslistajax', ['as' => 'eventmanager.eventslistajax', 'uses' => 'EventManager\DashboardController@eventsListing']);
	Route::get('/logout', ['as' => 'eventmanager.logout', 'uses' => 'EventManager\LoginController@logout']);



	// Users CRUD
	Route::match(['get', 'post'],'/users', ['as' => 'eventmanager.userlist', 'uses' => 'EventManager\UsersController@userListing']);
	Route::get('/adduser', ['as' => 'eventmanager.adduser', 'uses' => 'EventManager\UsersController@addUser']);
	Route::get('/loadstates/{countryId}/{stateId}', ['as' => 'eventmanager.loadstates', 'uses' => 'EventManager\EventManagerController@loadStates']);
	Route::post('/saveuser', ['as' => 'eventmanager.saveuser', 'uses' => 'EventManager\UsersController@saveUser']);
	Route::get('/userajaxdata', ['as' => 'eventmanager.userajaxdata', 'uses' => 'EventManager\UsersController@ajaxDataLoad']);
	Route::get('/edituser/{id}', ['as' => 'eventmanager.edituser', 'uses' => 'EventManager\UsersController@editUser']);
	Route::post('/updateuser', ['as' => 'eventmanager.updateuser', 'uses' => 'EventManager\UsersController@updateUser']);

	// Teams CRUD
	Route::match(['get', 'post'],'/teams', ['as' => 'eventmanager.teamlist', 'uses' => 'EventManager\TeamsController@teamListing']);
	Route::get('/addteam', ['as' => 'eventmanager.addteam', 'uses' => 'EventManager\TeamsController@addTeam']);
	Route::post('/saveteam', ['as' => 'eventmanager.saveteam', 'uses' => 'EventManager\TeamsController@saveTeam']);
	Route::get('/teamajaxdata', ['as' => 'eventmanager.teamajaxdata', 'uses' => 'EventManager\TeamsController@ajaxDataLoad']);
	Route::get('/editteam/{id}', ['as' => 'eventmanager.editteam', 'uses' => 'EventManager\TeamsController@editTeam']);
	Route::post('/updateteam', ['as' => 'eventmanager.updateteam', 'uses' => 'EventManager\TeamsController@updateTeam']);
	Route::post('/userexistinanyteam', ['as' => 'eventmanager.userexistinanyteam', 'uses' => 'EventManager\TeamsController@userExistInAnyTeam']);
	Route::post('/getteammembers', ['as' => 'eventmanager.getteammembers', 'uses' => 'EventManager\TeamsController@getTeamMembers']);


	// Events CRUD
	Route::match(['get', 'post'],'/events', ['as' => 'eventmanager.eventlist', 'uses' => 'EventManager\EventsController@eventListing']);
	Route::get('/addevent', ['as' => 'eventmanager.addevent', 'uses' => 'EventManager\EventsController@addEvent']);
	Route::post('/saveevent', ['as' => 'eventmanager.saveevent', 'uses' => 'EventManager\EventsController@saveEvent']);
	Route::get('/eventajaxdata', ['as' => 'eventmanager.eventajaxdata', 'uses' => 'EventManager\EventsController@ajaxDataLoad']);
	Route::get('/editevent/{id}', ['as' => 'eventmanager.editevent', 'uses' => 'EventManager\EventsController@editEvent']);
	Route::post('/updateevent', ['as' => 'eventmanager.updateevent', 'uses' => 'EventManager\EventsController@updateEvent']);

	Route::get('/eventdetails/{id}', ['as' => 'eventmanager.eventdetails', 'uses' => 'EventManager\EventsController@eventDetails']);
	Route::get('/eventajaxmembers/{id}', ['as' => 'eventmanager.eventajaxmembers', 'uses' => 'EventManager\EventsController@ajaxEventMembers']);


	Route::post('/setactiveinactive', ['as' => 'eventmanager.setactiveinactive', 'uses' => 'Admin\CommonController@setActiveInactive']);

	Route::post('/emaillist', ['as' => 'eventmanager.emaillist', 'uses' => 'EventManager\UsersController@getEmailIdsAjax']);

	Route::post('/getemailIdata', ['as' => 'eventmanager.getemailIdata', 'uses' => 'EventManager\UsersController@getEmailIData']);

	//Survey 
	Route::match(['get', 'post'],'/survey', ['as' => 'eventmanager.surveylist', 'uses' => 'EventManager\SurveyController@surveyListing']);
	Route::get('/surveyajaxdata', ['as' => 'eventmanager.surveyajaxdata', 'uses' => 'EventManager\SurveyController@ajaxDataLoad']);

});


Route::get('/socketisconnect', ['as' => 'socketisconnect', 'uses' => 'Front\FrontendController@socketisconnect']);

Route::get('/homepage/{encryptedId}', ['as' => 'homepage', 'uses' => 'Front\FrontendController@homepage']);
Route::get('/invalid', ['as' => 'invalid', 'uses' => 'Front\FrontendController@invalid']);

Route::get('/reflections', ['as' => 'reflections', 'uses' => 'Front\FrontendController@reflections']);
Route::get('/thankyou/{encryptedId}', ['as' => 'thankyou', 'uses' => 'Front\FrontendController@thankyou']);

Route::get('/tutorials', ['as' => 'tutorials', 'uses' => 'Front\FrontendController@tutorials']);

Route::post('/updateusername', ['as' => 'front.updateusername', 'uses' => 'Front\FrontendController@updateUserName']);
Route::get('/eventstart/{encryptedId}', ['as' => 'front.eventstart', 'uses' => 'Front\FrontendController@eventStart']);
Route::get('/awaitingscreen/{encryptedId}', ['as' => 'front.awaitingscreen', 'uses' => 'Front\FrontendController@awaitingScreen']);
Route::get('/funfacts/{encryptedId}', ['as' => 'front.funfacts', 'uses' => 'Front\FrontendController@funFacts']);
Route::get('/gamescreen/{encryptedId}', ['as' => 'front.gamescreen', 'uses' => 'Front\FrontendController@gameScreen']);
Route::get('/gamescreenanswer/{encryptedId}', ['as' => 'front.gamescreenanswer', 'uses' => 'Front\FrontendController@gamescreenanswer']);

Route::get('/gamescreenajax/{encryptedId}', ['as' => 'front.gamescreenajax', 'uses' => 'Front\FrontendController@gamescreenajax']);

Route::post('/gamescreensave', ['as' => 'front.gamescreensave', 'uses' => 'Front\FrontendController@gamescreensave']);

Route::post('/eventjoinuserscount', ['as' => 'front.eventjoinuserscount', 'uses' => 'Front\FrontendController@usersCountOfJoiny']);
Route::post('/savefunfact', ['as' => 'front.savefunfact', 'uses' => 'Front\FrontendController@saveFunFacts']);
Route::post('/userconnectedtosocket', ['as' => 'front.userconnectedtosocket', 'uses' => 'Front\FrontendController@saveSocketConnectedUser']);
Route::post('/getjoinedusers', ['as' => 'front.getjoinedusers', 'uses' => 'Front\FrontendController@getJoinedUsers']);
Route::get('/removesocketuser/{socketid}', ['as' => 'front.removesocketuser', 'uses' => 'Front\FrontendController@removeSocketUser']);

Route::post('/setquesapeared', ['as' => 'front.setquesapeared', 'uses' => 'Front\FrontendController@setquesapeared']);

Route::post('/update_ib_status', ['as' => 'front.update_ib_status', 'uses' => 'Front\FrontendController@updateIceBreakerStatus']);

Route::post('/checkfunfactstatus', ['as' => 'front.checkfunfactstatus', 'uses' => 'Front\FrontendController@checkMyFunFactStatus']);

Route::post('/getanswerdata', ['as' => 'front.getanswerdata', 'uses' => 'Front\FrontendController@getanswerdata']);

Route::get('/mmrulesscreen/{encryptedId}', ['as' => 'front.mmrulesscreen', 'uses' => 'Front\FrontendController@mMRulesScreen']);

Route::post('/getjoinedplayers', ['as' => 'front.getjoinedplayers', 'uses' => 'Front\FrontendController@getJoinedteamsForEvent']);

Route::post('/getibstatus', ['as' => 'front.getibstatus', 'uses' => 'Front\FrontendController@getIBstatus']);

Route::post('/getintorresult', ['as' => 'front.getintorresult', 'uses' => 'Front\FrontendController@getIntroGameResult']);

/*Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');*/

/* 
* Front Pages [ 
*/
Route::get('/', ['as' => 'front.index', 'uses' => 'Front\PagesController@index']);
Route::get('/about-us', ['as' => 'front.about_us', 'uses' => 'Front\PagesController@aboutUs']);
Route::post('/contact/send/request', ['as' => 'front.contact_send_request', 'uses' => 'Front\PagesController@contactSendRequest']);
Route::get('/contact', ['as' => 'front.contact', 'uses' => 'Front\PagesController@contact']);
Route::get('/faqs', ['as' => 'front.faqs', 'uses' => 'Front\PagesController@faqs']);
Route::get('/how-it-works', ['as' => 'front.how_it_works', 'uses' => 'Front\PagesController@howItWorks']);
Route::get('/packages', ['as' => 'front.packages', 'uses' => 'Front\PagesController@packages']);


//chat module routes
Route::post('/sendmessage', ['as' => 'front.sendmessage', 'uses' => 'Front\ChatsController@saveMessage']);
/*
* ]
*/

// routes for crime investigation
Route::group(['prefix' => 'crimeinvestigation'/*,  'middleware' => 'auth'*/], function(){
	Route::get('/splash/{encryptedId}', ['as' => 'crimeinvestigation.splash', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@splash']);
	Route::get('/evidence/{encryptedId}', ['as' => 'crimeinvestigation.evidence', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@evidence']);
	Route::get('/newspapper/{encryptedId}', ['as' => 'crimeinvestigation.newspapper', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@newspapper']);
	Route::get('/overview/{encryptedId}', ['as' => 'crimeinvestigation.overview', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@overview']);
	Route::get('/file_closed/{encryptedId}', ['as' => 'crimeinvestigation.file_closed', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@file_closed']);

	Route::get('/dmv/{encryptedId}', ['as' => 'crimeinvestigation.dmv', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@dmv']);
	Route::post('/dmv_detail/{encryptedId}', ['as' => 'crimeinvestigation.dmv_detail', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@dmv_detail']);

	Route::get('/mansion/{encryptedId}', ['as' => 'crimeinvestigation.mansion', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@mansion']);

	Route::get('/suspects/{encryptedId}', ['as' => 'crimeinvestigation.suspects', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@suspects']);
	Route::get('/suspects_detail/{id}/{encryptedId}', ['as' => 'crimeinvestigation.suspects_detail', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@suspects_detail']);

	Route::get('/partyphotos/{encryptedId}', ['as' => 'crimeinvestigation.partyphotos', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@partyphotos']);

	Route::get('/security_photos/{encryptedId}', ['as' => 'crimeinvestigation.security_photos', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@security_photos']);
	// Route::get('/old_police_report', ['as' => 'crimeinvestigation.old_police_report', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@old_police_report']);

	Route::post('/ci_submit', ['as' => 'crimeinvestigation.ci_submit', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@ci_submit']);
	Route::post('/take_interview', ['as' => 'crimeinvestigation.take_interview', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@takeInterview']);
	Route::post('/search_house', ['as' => 'crimeinvestigation.search_house', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@searchHouse']);
	Route::get('/access_security_camra/{encryptedId}', ['as' => 'crimeinvestigation.access_security_camra', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@accessSecurityCamra']);
	Route::post('/get_fingerprints', ['as' => 'crimeinvestigation.get_fingerprints', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@getFingerprints']);
	Route::post('/search_mansion', ['as' => 'crimeinvestigation.search_mansion', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@searchMansion']);
	Route::post('/catch_thief', ['as' => 'crimeinvestigation.catch_thief', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@catchThief']);
	Route::post('/compare_gloves', ['as' => 'crimeinvestigation.compare_gloves', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@compareGloves']);
	Route::post('/game_over', ['as' => 'crimeinvestigation.game_over', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@gameOver']);
	Route::post('/hintunlock', ['as' => 'crimeinvestigation.hintunlock', 'uses' => 'CrimeInvestigation\CrimeInvestigationController@unlockQuesHint']);

});