<?php

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home') ->middleware('verified');

Route::get('/',function(){

    return 'Home';
});



Route::get('/dashboard',function(){

    return 'dashboard';
});
