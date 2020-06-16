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
    return view('index');
});

Auth::routes();

Route::get('/admin', 'AdminController@index')->name('admin.home');
Route::get('/admin-kelola-periode', 'PeriodeController@index')->name('admin.periode');
Route::post('/admin-store-periode', 'PeriodeController@store')->name('admin.periode.update');
Route::put('/admin-update-periode', 'PeriodeController@update')->name('admin.periode.update');
Route::get('/admin-kelola-users', 'AdminController@kelolaUser')->name('admin.users');
Route::get('/admin-pilih-periode', 'ManajemenUangController@pilihPeriode')->name('admin.pilih.periode');
Route::get('/admin-show-manajemen-periode', 'ManajemenUangController@showManajemenUangPeriode')->name('admin.show.keuangan');
Route::get('/admin-store-pengeluaran', 'ManajemenUangController@storePengeluaran')->name('admin.store.pengeluaran');
Route::get('/admin-store-update-pengeluaran', 'ManajemenUangController@updatePengeluaran')->name('admin.update.pengeluaran');
Route::get('/home', 'HomeController@index')->name('home');
