<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('layouts.components.dashboard');
});

Route::get('/home', function () {
    return view('layouts.components.dashboard');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('account', AccountController::class);
    Route::get('getAccount', [AccountController::class, 'getAccount'])->name('account.getAccount');

    Route::resource('customer', CustomerController::class);
    Route::get('getCustomer', [CustomerController::class, 'getCustomer'])->name('customer.getCustomer');

    Route::resource('order', OrderController::class);
    Route::get('editc/{id}/{idc}', [OrderController::class, 'editc'])->name('order.editc');
    Route::put('updatec/{id}', [OrderController::class, 'updatec'])->name('order.updatec');
    Route::get('getOrder', [OrderController::class, 'getOrder'])->name('order.getOrder');
    Route::get('getOrderByCustomer', [OrderController::class, 'getOrderByCustomer'])->name('order.getOrderByCustomer');
    Route::get('appointment', [OrderController::class, 'appointment'])->name('appointment');
    Route::get('getAppointment', [OrderController::class, 'getAppointment'])->name('order.getAppointment');
    Route::get('createAppointment', [OrderController::class, 'createAppointment'])->name('order.createAppointment');
    Route::post('storeAppointment', [OrderController::class, 'storeAppointment'])->name('order.storeAppointment');
    Route::get('editAppointment/{id}', [OrderController::class, 'editAppointment'])->name('order.editAppointment');
    Route::put('updateAppointment/{id}', [OrderController::class, 'updateAppointment'])->name('order.updateAppointment');


    Route::resource('product', ProductController::class);
    Route::get('getProduct', [ProductController::class, 'getProduct'])->name('product.getProduct');
    Route::get('getSubCategory/{id}', [ProductController::class, 'getSubCategory'])->name('product.getSubCategory');
});
