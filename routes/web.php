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
    return view('welcome');
});

Route::get('/stocks', function () {
    return view('stocks');
});

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

