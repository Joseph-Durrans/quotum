<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['request' => false, 'reset' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/user-panel', 'loggedInPanelController@index')->name('loggedInPanel');

    Route::get('/stocks', 'StocksController@index')->name('stocks');

    Route::get('/stocks/{stock}', function ($stock) {

        $stocks = [
            'BARC' => [
                'title' => 'Barclays',
                'content' => 'Barclays PLC shares'
            ],
            'RYA' => [
                'title' => 'Ryanair',
                'content' => 'Ryanair Holdings plc shares'
            ]
        ];

        return view('single_stock',[
            'post' => $stocks[$stock]
        ]);
    });

});
