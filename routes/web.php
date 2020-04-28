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

    return 'Not adualt';
}) -> name('not.adult');

Route::get('/redirect/{service}', 'SocialController@redirect');

Route::get('/callback/{service}', 'SocialController@callback');


Route::get('fillable', 'CrudController@getOffers');


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::group(['prefix' => 'offers'], function () {
        //   Route::get('store', 'CrudController@store');
        Route::get('create', 'CrudController@create');
        Route::post('store', 'CrudController@store')->name('offers.store');

        Route::get('edit/{offer_id}', 'CrudController@editOffer');
        Route::post('update/{offer_id}', 'CrudController@UpdateOffer')->name('offers.update');
        Route::get('delete/{offer_id}', 'CrudController@delete')->name('offers.delete');
        Route::get('all', 'CrudController@getAllOffers')->name('offers.all');
    });

    Route::get('youtube', 'CrudController@getVideo') ->middleware('auth');
});


###################### Begin Ajax routes #####################
Route::group(['prefix' => 'ajax-offers'], function () {
    Route::get('create', 'OfferController@create');
    Route::post('store', 'OfferController@store')->name('ajax.offers.store');
    Route::get('all', 'OfferController@all')->name('ajax.offers.all');
    Route::post('delete', 'OfferController@delete')->name('ajax.offers.delete');
    Route::get('edit/{offer_id}', 'OfferController@edit')->name('ajax.offers.edit');
    Route::post('update', 'OfferController@Update')->name('ajax.offers.update');
});
###################### End Ajax routes #####################


##################### Begin Authentication && Guards ##############

Route::group(['middleware' => 'CheckAge','namespace' => 'Auth'], function () {
    Route::get('adults', 'CustomAuthController@adualt')-> name('adult');
});
                                                                //middleware('auth')
Route::get('site', 'Auth\CustomAuthController@site')->middleware('auth:web')-> name('site');
Route::get('admin', 'Auth\CustomAuthController@admin')->middleware('auth:admin') -> name('admin');

Route::get('admin/login', 'Auth\CustomAuthController@adminLogin')-> name('admin.login');
Route::post('admin/login', 'Auth\CustomAuthController@checkAdminLogin')-> name('save.admin.login');


##################### End Authentication && Guards ##############




