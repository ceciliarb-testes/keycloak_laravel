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

Route::get('/', function() {
    return view('welcome');
});

Route::get('/token', "OpenIdController@token");

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/index', function() {
    return view('index');
});

// protected endpoints
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/protected-endpoint', 'SecretController@index');
});

Route::get('/login', "OpenIdController@login")->name('login');
Route::any('/logout', "OpenIdController@logout")->name('logout');
