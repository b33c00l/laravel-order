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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('sort/', 'HomeController@sort')->name('home.sort');

Route::post('products/import', 'ProductsImportController@import')->name('products.import');
Route::get('products/import', 'ProductsImportController@importForm')->name('products.import.form');
Route::get('products/import/log', 'ProductsImportController@showLog')->name('products.import.log');
Route::post('products/import/log', 'ProductsImportController@filter')->name('products.import.filter');
Route::get('cat/{id}', 'CategoriesController@show')->name('products.cat');

Route::get('chat', 'ChatsController@index')->name('chat.index')->middleware('role:user');
Route::get('chat/create', 'ChatsController@create')->name('chat.create');
Route::post('chat/store', 'ChatsController@store')->name('chat.store');
Route::get('chat/user', 'ChatsController@getUserChats')->name('chat.user');
Route::get('chat/{chat}', 'ChatsController@show')->name('chat.show');
Route::post('chat/store_message', 'ChatsController@storeMessage')->name('chat.store.message');
Route::patch('chat/disable', 'ChatsController@disable')->name('chat.disable');
Route::patch('chat/enable', 'ChatsController@enable')->name('chat.enable');


Route::resource('publishers', 'PublishersController');
Route::resource('platforms', 'PlatformController');

Route::resource('products', 'ProductsController');
Route::get('search/', 'SearchController@search')->name('products.search');

Route::resource('users', 'UsersController');
Route::resource('categories', 'CategoriesController');

Route::post('order/{id}', 'CartController@store')->name('order.store');
Route::get('basket', 'CartController@index')->name('order.index');
Route::post('cart/{id}', 'CartController@confirm')->name('cart.confirm');
Route::get('orders', 'OrdersController@index')->name('order.orders');
Route::get('order/{id}', 'OrdersController@show')->name('order.products');
Route::put('order/{id}/action', 'OrdersController@action')->name('order.action');

Route::post('update/{id}', 'CartController@update')->name('order.update');
Route::delete('order/{id}', 'CartController@destroy')->name('order.product.delete');

Route::get('contacts', 'HomeController@contacts')->name('pages.contacts');
