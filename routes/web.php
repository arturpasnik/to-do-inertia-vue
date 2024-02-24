<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
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
Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])->name('task.index');
Route::post('/', [\App\Http\Controllers\TaskController::class, 'store'])->name('task.store');
Route::put('/', [\App\Http\Controllers\TaskController::class, 'update'])->name('task.update');
Route::delete('/', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('task.destroy');











