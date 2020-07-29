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
    // sales Route
    Route::match(['get', 'post'], '/sales', 'SalesController@index')->name('sales.index');
    Route::post('sales/store', 'SalesController@store')->name('sales.store');
    Route::resource('sales', 'SalesController', ['except' => ['index', 'store']]);

    // purchase route
    Route::match(['get', 'post'], '/purchase', 'PurchaseController@index')->name('purchase.index');
    Route::post('purchase/store', 'PurchaseController@store')->name('purchase.store');
    Route::resource('purchase', 'PurchaseController', ['except' => ['index', 'store']]);
});

// ledger route
Route::prefix('ledger')->group(function () {
    // ledger account route
    Route::resource('account', 'LedgerAccountController');
    // ledger entry route
    Route::resource('entry', 'LedgerEntryController');
});

// Journal Voucher Routes
Route::prefix('journal')->group(function () {
    // receipt route
    Route::match(['get', 'post'], '/receipt', 'ReceiptController@index')->name('receipt.index');
    Route::post('receipt/store', 'ReceiptController@store')->name('receipt.store');
    Route::resource('receipt', 'ReceiptController', ['except' => ['index', 'store']]);

    // payment route
    Route::match(['get', 'post'], '/payment', 'PaymentController@index')->name('payment.index');
    Route::post('payment/store', 'PaymentController@store')->name('payment.store');
    Route::resource('payment', 'PaymentController', ['except' => ['index', 'store']]);
});

// Note Voucher Routes
Route::prefix('note')->group(function () {
    // debit note route
    Route::match(['get', 'post'], '/debit', 'DebitController@index')->name('debit.index');
    Route::post('debit/store', 'DebitController@store')->name('debit.store');
    Route::resource('debit', 'DebitController', ['except' => ['index', 'store']]);

    // credit note route
    Route::match(['get', 'post'], '/credit', 'CreditController@index')->name('credit.index');
    Route::post('credit/store', 'CreditController@store')->name('credit.store');
    Route::resource('credit', 'CreditController', ['except' => ['index', 'store']]);
});
