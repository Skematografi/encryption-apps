<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::permanentRedirect('/', '/login');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UsersController');
Route::resource('roles', 'RolesController');
Route::resource('storages', 'StoragesController');
Route::post('/rename', 'StoragesController@rename')->name('rename');
Route::get('/download/{id}', 'StoragesController@download')->name('download');
Route::post('/encryption', 'StoragesController@encryption')->name('encryption');
Route::get('/decryption/{id}', 'StoragesController@decryption')->name('decryption');

