<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'areas' => \App\Models\Area::active()->get()
    ]);
});

Route::get('/dashboard', function () {
    return redirect()->route(
        auth()->user()->role === 'admin' ? 'admin.dashboard' : 'rider.dashboard'
    );
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::view('/dashboard', 'rider.dashboard')->name('dashboard');
    Route::get('/register', [RiderController::class, 'create'])->name('create');
    Route::post('/register', [RiderController::class, 'store'])->name('store');
    Route::get('/profile', [RiderController::class, 'show'])->name('show');
    Route::post('/reapply', [RiderController::class, 'reapply'])->name('reapply');
    Route::get('/edit', [RiderController::class, 'edit'])->name('edit');
    Route::patch('/edit', [RiderController::class, 'update'])->name('update');
    Route::post('/interview/attendance', [RiderController::class, 'updateAttendance'])->name('interview.attendance');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('/riders', [AdminController::class, 'index'])->name('riders.index');
    Route::get('/riders/{riderProfile}', [AdminController::class, 'show'])->name('riders.show');
    Route::get('/riders/{riderProfile}/download-cv', [AdminController::class, 'downloadCv'])->name('riders.download-cv');
    Route::patch('/riders/{riderProfile}/status', [AdminController::class, 'updateStatus'])->name('riders.update-status');

    Route::resource('areas', AreaController::class)->except(['create', 'show', 'edit']);
    Route::post('/areas/{area}/toggle', [AreaController::class, 'toggle'])->name('areas.toggle');
});

require __DIR__.'/auth.php';
