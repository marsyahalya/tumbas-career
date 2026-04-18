<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiderController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('rider.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rider Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', function () {
        return view('rider.dashboard');
    })->name('dashboard');
    Route::get('/register',  [RiderController::class, 'create'])->name('create');
    Route::post('/register', [RiderController::class, 'store'])->name('store');
    Route::get('/profile',   [RiderController::class, 'show'])->name('show');
    Route::post('/reapply',  [RiderController::class, 'reapply'])->name('reapply');
    Route::get('/edit',      [RiderController::class, 'edit'])->name('edit');
    Route::patch('/edit',    [RiderController::class, 'update'])->name('update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('/riders',                      [AdminController::class, 'index'])->name('riders.index');
    Route::get('/riders/{riderProfile}',       [AdminController::class, 'show'])->name('riders.show');
    Route::get('/riders/{riderProfile}/download-cv', [AdminController::class, 'downloadCv'])->name('riders.download-cv');
    Route::patch('/riders/{riderProfile}/status', [AdminController::class, 'updateStatus'])->name('riders.update-status');

    // Area CRUD
    Route::resource('areas', \App\Http\Controllers\Admin\AreaController::class)->except(['create', 'show', 'edit']);
    Route::post('/areas/{area}/toggle', [\App\Http\Controllers\Admin\AreaController::class, 'toggle'])->name('areas.toggle');
});

require __DIR__.'/auth.php';

