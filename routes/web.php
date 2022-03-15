<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
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
     return view('top');
})->name('top');

Route::get('/dashboard', function () {
     return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/user/profile', [UserController::class, 'show'])
     ->middleware('auth')
     ->name('user.profile');

Route::delete('/user/{user}', [UserController::class, 'destroy'])
     ->name('user.destroy');

Route::controller(PostController::class)->prefix('posts')->name('posts')->group(function () {
     Route::get('/', 'list');
     Route::get('/create', 'create')->name('.create');
     Route::post('/create', 'store')->name('.store');
     Route::get('/{post}', 'show')->name('.show');
     Route::get('/{post}/edit', 'edit')->name('.edit');
     Route::put('/{post}', 'update')->name('.update');
     Route::delete('/{post}', 'destroy')->name('.destroy');
});
