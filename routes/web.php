<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Config\Users;
use App\Http\Livewire\Category\Categories;
use App\Http\Livewire\Tag\Tags;
use App\Http\Controllers\MapController;

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
    //return view('login');
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', Users::class)->name('users');
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/tags', Tags::class)->name('tags');

    Route::resource('mapas', MapController::class);
});
