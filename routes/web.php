<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\bibitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CetakController;
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
Route::get('/',function(){
    return view('welcome',[
        "title"=>"Dashboard"
    ]);
});

Route::resource('pelanggan',PelangganController::class)->except('destory');
Route::resource('bibit',bibitController::class);
Route::resource('user',UserController::class)->except('destroy','create','show','update','edit');

Route::get('login',[LoginController::class,'loginView'])->name('login');
Route::post('login',[LoginController::class,'authenticate']);


Route::post('/logout',[LoginController::class,'logout'])->name('auth.logout');


Route::get('penjualan',function(){
    return view('penjualan.index',[
        "title"=>"Penjualan"
    ]);
})->name('penjualan');

Route::get('transaksi',function(){
    return view('penjualan.transaksis',[
        "title"=>"transaksi"
    ]);
});

Route::get('cetakReceipt',[CetakController::class,'receipt'])->name('cetakReceipt');