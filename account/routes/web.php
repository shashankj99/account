<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['can:isAdmin']], function () {
    // user route
    Route::resource('user', 'UserController'); 
});

// company route
Route::resource('company', 'CompanyController');

// category route
Route::resource('category', 'CategoryController');

// invoice wise sales and purchase route
Route::prefix('invoice')->group(function () {
    Route::match(['get', 'post'], '/sales', 'SalesController@index')->name('sales.index');
    Route::post('sales/store', 'SalesController@store')->name('sales.store');
    Route::resource('sales', 'SalesController', ['except' => ['index', 'store']]);
});
