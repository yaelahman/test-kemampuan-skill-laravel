<?php

use App\Http\Controllers\FormulirController;
use App\Http\Controllers\LoginController;
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

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::prefix('formulir')->name('formulir')->group(function () {
        Route::get('index', [FormulirController::class, 'index'])->name('.index');
        Route::get('create', [FormulirController::class, 'create'])->name('.create');
        Route::post('store', [FormulirController::class, 'store'])->name('.store');
        Route::get('delete/{id}', [FormulirController::class, 'delete'])->name('.delete');
        Route::get('edit/{id}', [FormulirController::class, 'edit'])->name('.edit');
        Route::get('detail/{id}', [FormulirController::class, 'detail'])->name('.detail');
        Route::post('approval/{id}', [FormulirController::class, 'approval'])->name('.approval');
    });
});
