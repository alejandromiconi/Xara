<?php

use App\Http\Controllers\CrudController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UdcController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware('auth'); // This will automatically redirect unauthenticated users to login

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix("/transaction/{name}")
     ->controller(TransactionController::class)
     ->group(function () {

        // Specific routes first (more specific -> less specific)
        Route::get('import', 'import');
        Route::post('import', 'upload');
        Route::post('export', 'export');

        Route::get('{action}/{id}', 'show'); 
        Route::post('store', 'store');

        Route::any('', 'transaction');
     });


    Route::prefix("/udcs/{doctype}")
     ->controller(UdcController::class)
     ->group(function () {

        // Specific routes first (more specific -> less specific)
        Route::get('import', 'import');
        Route::post('import', 'upload');
        Route::post('export', 'export');

        Route::get('{action}/{id}', 'show'); 
        Route::post('store', 'store');

        Route::any('', 'udcs');
     });

     Route::prefix("/crud/{name}")
     ->controller(CrudController::class)
     ->group(function () {

        // Specific routes first (more specific -> less specific)
        Route::get('import', 'import')->name('crud.import');
        Route::post('import', 'upload')->name('crud.upload.file');
        Route::post('export', 'export')->name('crud.export');

        // CRUD operations with explicit actions
        Route::get('{action}/{id}', 'show')->name('crud.show');
        Route::post('store', 'store')->name('crud.store');

        // Filter and index (keep at bottom since it's more general)
        Route::any('', 'index')->name('crud.index');
     });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';
