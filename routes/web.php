<?php

use App\Mail\NotifyEmail;
use Illuminate\Support\Facades\Mail;

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/', function () {

    //return 'Home';
    $data = ['title' => 'progrmming', 'body' => 'php'];
    Mail::To('dhhfsdsd@gmail.com')->send(new NotifyEmail($data));
});


Route::get('/dashboard', function () {

    return 'dashboard';
});

Route::get('/redirect/{service}', 'SocialController@redirect');

Route::get('/callback/{service}', 'SocialController@callback');


Route::get('fillable', 'CrudController@getOffers');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::group(['prefix' => 'offers'], function () {
        //   Route::get('store', 'CrudController@store');
        Route::get('create', 'CrudController@create');
        Route::post('store', 'CrudController@store')->name('offers.store');
    });
});





