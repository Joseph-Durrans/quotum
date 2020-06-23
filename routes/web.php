<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['request' => false, 'reset' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/user-panel', 'loggedInPanelController@index')->name('loggedInPanel');

    Route::get('/user-panel/stocks', 'StocksController@index')->name('stocks');
    Route::post('/user-panel/stocks', 'StocksController@search')->name('stocks_search');

    Route::get('/user-panel/stocks/{stock}', 'SingleStockController@index')->name('stock');
});

