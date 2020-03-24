<?php

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

Route::get('/', 'MapController@index');

Route::get('/politica', function () {
    return view('politica');
});

Route::get('/sobre', function () {
    return view('about');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/facebook/redirect', 'SocialAuthController@redirect');
Route::get('/facebook/callback', 'SocialAuthController@callback');

Route::post('/data', 'DataController@store')->name('data_store');


