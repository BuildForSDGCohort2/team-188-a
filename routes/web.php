<?php

use App\Image;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	if (auth()->user() === null) {
		return view('welcome');
	}else {
		return redirect('home');
	}

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::get('stores','StorageController@all_items')->name('storage');
	Route::post('plantation/{id}/schedule_harvest','StorageController@schedule_harvest')->name('scheduleharvest');
	Route::post('plantation/{id}/harvest','StorageController@harvest')->name('harvest');
	Route::get('orders','OrdersController@my_orders')->name('orders');
	Route::resource('plant', 'PlantsController', ['except' => ['create']]);

	Route::post('deduct/{id}/brood','BroodsController@deduct')->name('deduct_brood_number');
	Route::post('sell/{id}/brood','BroodsController@sell_bird')->name('sell_poultry');
	Route::resource('brood', 'BroodsController', ['except' => ['create']]);

	Route::post('death/{id}/animal','AnimalsController@death')->name('death_of_animal');
	Route::post('sell/{id}/animal','AnimalsController@sell_animal')->name('sell_animal');
	Route::resource('animal', 'AnimalsController', ['except' => ['create']]);

	Route::get('notifications','NotificationsController@notification_selector')->name('notifications');
	Route::get('pending_suppliers','NotificationsController@get_suppliers')->name('pending_suppliers');
	Route::get('issues','NotificationsController@get_issues')->name('issues');
	Route::post('sell/{id}/product','StorageController@sell_from_storage')->name('sell_from_storage');
	Route::post('take/{id}/product','StorageController@take_from_storage')->name('take_from_storage');

	Route::post('order/{id}/product','OrdersController@place_order')->name('place_order');
	Route::get('order/dispatch','OrdersController@dispatch_orders')->name('dispatch');
	Route::get('order/{orders}/dispatch','OrdersController@order_pick_up')->name('transit');


	Route::any('request_regiment','PlantsController@request_regiment')->name('request_regiment');


	Route::any('summon_proffesional','AnimalsController@summon_proffesional')->name('summon_proffesional');

	Route::any('request_regiment','PlantsController@request_regiment')->name('request_regiment');


	Route::get('parent','AnimalsController@parent')->name('parent');
	Route::get('get_animal','AnimalsController@get_animal')->name('get_animal');
	Route::get('get_notifications','NotificationsController@get_notifications')->name('get_notifications');

	#to read info
	Route::post('isue/{id}/read','IssueController@mark_as_read')->name('read_issue');

    Route::post('account/{id}/decison','EnrolmentController@account_decision')->name('proffesional_account_decision');


    Route::post('confirmation/{id}','EnrolmentController@confirmation')->name('confirmation');
    Route::post('rejection/{id}','EnrolmentController@rejection')->name('rejection');


	Route::get('fact_sheet/{search}','BrowseController@fact_sheet')->name('fact_sheet');
	Route::get('plant_fact_sheet/{search}','BrowseController@plant_fact_sheet')->name('plant_fact_sheet');

	Route::get('recievers_dash','OrdersController@recievers_dash')->name('receivers_dash');
	Route::get('ready_for_pickup','OrdersController@ready_for_pickup')->name('ready_for_pickup');
	Route::get('waiting_user_requests','HomeController@waiting_user_requests')->name('waiting_user_requests');

});

Route::resource('cart', 'CartController');


// enrolement
Route::post('profesionals_enrole','EnrolmentController@profesionals_enrole')->name('profesionals_enrole');
Route::post('suppliers_enrole','EnrolmentController@suppliers_enrole')->name('suppliers_enrole');
Route::post('farmers_enrole','EnrolmentController@farmers_enrole')->name('farmers_enrole');
Route::post('customers_enrole','EnrolmentController@customers_enrole')->name('customer_enrole');

Route::post('send_message/{id}','NotificationsController@send_message')->name('send_message');

Route::post('customer_enrole','EnrolmentController@customer_enrole')->name('customer_enrole');

Route::get('on_sale','OrdersController@for_sale')->name('on_sale');
Route::get('on_sale/{id}/view','OrdersController@view_prod')->name('viewprod');


Route::get('search_brood/{search}','BroodsController@search_brood')->name('search_brood');

Route::get('professionals','BrowseController@professionals')->name('professionals');
Route::get('suppliers','BrowseController@suppliers')->name('suppliers');


Route::get('/login/{social}','Auth\LoginController@socialLogin')->where('social','twitter|facebook|linkedin|google|github|bitbucket');
Route::get('/login/{social}/callback','Auth\LoginController@handleProviderCallback')->where('social','twitter|facebook|linkedin|google|github|bitbucket');

Route::get('login/instagram', 'Auth\LoginController@redirectToInstagramProvider')->name('instagram.login');

Route::get('login/instagram/callback', 'Auth\LoginController@instagramProviderCallback')->name('instagram.login.callback');
Route::get('show_issue/{id}','NotificationsController@show_issue')->name('show_issue');
Route::get('summon_request/{id}','NotificationsController@summon_request')->name('summon_request');

Route::post('issue_req/{id}/{text}','NotificationsController@issue_req')->name('issue_req');

Route::get('about-us', function () {
    return view('pages.about');
});

Route::any('/ussd', 'UssdController@ussdRequestHandler');


