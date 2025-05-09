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

Auth::routes();

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name("");
    Route::get('/','HomeController@index')->name("");

    //CITIZENS
    Route::get('/citizens','CitizenController@index')->name('citizens');
    Route::post('/citizens/postdata','CitizenController@postdata')->name('citizens.postdata');
    Route::get('/citizens/fetchdata','CitizenController@fetchdata')->name('citizens.fetchdata');
    Route::get('/citizens/removedata','CitizenController@removedata')->name('citizens.removedata');
    Route::get('/citizens/massremove','CitizenController@massremove')->name('citizens.massremove');
    Route::get('/citizens/getdata','CitizenController@getdata')->name('citizens.getdata');


    //ACCIDENTS
    Route::get('/accidents','AccidentsController@index')->name('accidents');
    Route::get('/accidents/fetchdata','AccidentsController@fetchdata')->name('accidents.fetchdata');
    Route::post('/accidents/postdata','AccidentsController@postdata')->name('accidents.postdata');
    Route::get('/accidents/getdata','AccidentsController@getdata')->name('accidents.getdata');
    Route::get('/accidents/persons','AccidentsController@persons')->name('accidents.persons');
    Route::get('/accidents/responders','AccidentsController@responders')->name('accidents.responders');
    Route::get('/accidents/removedata','AccidentsController@removedata')->name('accidents.removedata');
    Route::get('/accidents/massremove','AccidentsController@massremove')->name('accidents.massremove');
    Route::get('/accidents/getName','AccidentsController@getName')->name('accidents.getName');
    Route::get('/accidents/getName2','AccidentsController@getName2')->name('accidents.getName2');
    Route::get('/accidents/citizendata','AccidentsController@citizendata')->name('accidents.citizendata');
    Route::get('/accidents/rescuerdata','AccidentsController@rescuerdata')->name('accidents.rescuerdata');


    //RESCUERS
    Route::get('/rescuers','RescuerController@index')->name('rescuers');
    Route::post('/rescuers/postdata','RescuerController@postdata')->name('rescuers.postdata');
    Route::get('/rescuers/fetchdata','RescuerController@fetchdata')->name('rescuers.fetchdata');
    Route::get('/rescuers/removedata','RescuerController@removedata')->name('rescuers.removedata');
    Route::get('/rescuers/massremove','RescuerController@massremove')->name('rescuers.massremove');
    Route::get('/rescuers/getdata','RescuerController@getdata')->name('rescuers.getdata');


    //ITEMS
    Route::get('/items','ItemsController@index')->name('items');
    Route::post('/items/postdata','ItemsController@postdata')->name('items.postdata');
    Route::get('/items/fetchdata','ItemsController@fetchdata')->name('items.fetchdata');
    Route::get('/items/removedata','ItemsController@removedata')->name('items.removedata');
    Route::get('/items/massremove','ItemsController@massremove')->name('items.massremove');
    Route::get('/items/getdata','ItemsController@getdata')->name('items.getdata');
    Route::get('/items/persons','ItemsController@persons')->name('items.persons');
    Route::get('/items/getName','ItemsController@getName')->name('items.getName');

    //SMS
    Route::get('/messages','SmsController@index')->name('messages');
    Route::post('/messages/sendsms','SmsController@sendSMS')->name('messages.sendsms');
    Route::get('/messages/allsms','SmsController@allSMS')->name('messages.allsms');
    Route::get('/messages/sendpushnotification','SmsController@sendPushNotification')->name('messages.sendpushnotification');

    //MOBILE USERS
    Route::get('/mobile-users','MobileUsersController@index')->name('mobile-users');
    Route::get('/mobile-users/getdata','MobileUsersController@getdata')->name('mobile-users.getdata');



    Route::get('/map', function () {
        return view('map');
    })->name('map');

    //DATA ANALYSIS
    Route::get('/analytics','AnalyticsController@index')->name('analytics');
    Route::get('/analytics/citizensBarangay','AnalyticsController@citizensBarangay')->name('analytics.citizensBarangay');

    //REPORTS
    Route::get('/accidents/generate_accidents_per_month','AccidentsController@generate_accidents_per_month')->name('accidents.generate_accidents_per_month');
    Route::get('/accidents/generate_accidents_per_barangay','AccidentsController@generate_accidents_per_barangay')->name('accidents.generate_accidents_per_barangay');
    Route::get('/accidents/generate_accidents_per_place','AccidentsController@generate_accidents_per_place')->name('accidents.generate_accidents_per_place');

});

