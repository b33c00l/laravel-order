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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//// Platform Route
Route::get('/platforms', 'PlatformController@index')->name('platforms.index');
Route::get('/platforms/create', 'PlatformController@create')->name('platforms.create');
Route::post('/platforms/store', 'PlatformController@store')->name('platforms.store');
Route::get('/platforms/single/{id}', 'PlatformController@single')->name('platforms.single');
Route::get('/platforms/edit/{id}', 'PlatformController@edit')->name('platforms.edit');
Route::get('/platforms/delete/{id}', 'PlatformController@destroy')->name('platforms.delete');
Route::post('/platforms/update/{id}', 'PlatformController@update')->name('platforms.update');


Route::resource('users', 'UsersController');
