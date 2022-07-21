<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Profile;

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

Route::get('/test', function () {
    return view('layout.index');
});
Route::get('/test-login', function () {
    return view('layout.signin');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [Dashboard::class,  '__invoke'])->name('dashboard');
    Route::get('/profile/{id}', [Profile::class,  '__invoke'])->name('profile');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
