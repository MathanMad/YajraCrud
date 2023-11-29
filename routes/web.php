<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\TestController;

Route::get('index',[TestController::class, 'index'])->name('index');
Route::get('fetch_data',[TestController::class, 'fetch_data'])->name('fetchinfo');
Route::post('store',[TestController::class, 'store'])->name('store');
Route::get('edit/{id}',[TestController::class, 'edit'])->name('edit');
Route::post('update',[TestController::class,'update'])->name('update');
Route::delete('delete/{id}',[TestController::class, 'delete'])->name('delete');
