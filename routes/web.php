<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Guest;

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

// route / untuk diarahkan ke halaman guest jika belum login jika sudah akan diarahkan ke dashboard
Route::get('/', function () {
    return redirect()->route('index-guest');
});

// route hanya untuk user yang belum login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/index-guest', [Guest::class,  '__invoke'])->name('index-guest');
});

// route hanya untuk user sudah login
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [Dashboard::class,  '__invoke'])->name('dashboard');
    Route::get('/profile/{id}', [Profile::class,  '__invoke'])->name('profile');
});

require __DIR__.'/auth.php';
