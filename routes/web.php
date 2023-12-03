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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('product', 'ProductController');
Route::resource('supplier', 'SupplierController');
Route::resource('users', 'UsersController');
Route::resource('out_standing_po', 'OutStandingPOController');
Route::resource('return_pmr', 'ReturnPmrController');

Route::post('detail_product/store', 'ProductController@storeDetail');
Route::get('data/product', 'ProductController@dataProduct');
Route::post('data/items', 'ProductController@dataItems');
Route::get('data/supplier', 'SupplierController@dataSupplier');
Route::get('data/standing', 'OutStandingPOController@dataStanding');
Route::post('data/po_standing', 'OutStandingPOController@dataPoStanding');

Route::get('/report', 'ReportController@index')->name('report');
Route::post('/report/print', 'ReportController@printReport')->name('printReport');

