<?php

use App\Http\Controllers\TechBuzzWordsController;
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

Route::controller(TechBuzzWordsController::class)->group(function() {
    Route::get('/ninjify', 'getName')->name('getName');
    Route::get('/techs', 'searchTech')->name('techs.search');
});

Route::get('/', fn() => view('app'));

