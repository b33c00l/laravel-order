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


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');

Route::resource('publishers', 'PublishersController');
Route::resource('platforms', 'PlatformController');

Route::resource('products', 'ProductsController');

Route::resource('users', 'UsersController');
Route::resource('categories', 'CategoriesController');

Route::post('order/{id}', 'CartController@store')->name('order.store');
Route::get('basket', 'CartController@index')->name('order.index');
Route::post('cart/{id}', 'CartController@confirm')->name('order.confirm');

Route::post('update/{id}', 'CartController@update')->name('order.update');
Route::delete('order/{id}', 'CartController@destroy')->name('order.product.delete');


Route::post('products/import', 'ProductsImportController@import')->name('products.import');
Route::get('products/import', 'ProductsImportController@importForm')->name('products.import.form');
