<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [CategoryController::class, 'index'])->name('home');
Route::get('categories/create', [CategoryController::class, 'create'])->name('create');
Route::post('categories/store', [CategoryController::class, 'store'])->name('store');
Route::get('categories/show/{id}', [CategoryController::class, 'show'])->name('show');
Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
Route::put('categories/update/{id}', [CategoryController::class, 'update'])->name('update');
Route::get('categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
