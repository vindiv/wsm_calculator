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

Route::get('/effetti_allenamento', function() {
    return view('effetti_allenamento');
});

Route::post('/carica-xml', [App\Http\Controllers\XMLController::class, 'caricaXML'])->name('carica-xml');