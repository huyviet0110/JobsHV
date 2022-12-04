<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');

Route::group([
    'prefix' => 'users',
    'as'     => 'users.',
], static function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::group([
    'prefix' => 'posts',
    'as'     => 'posts.',
], static function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/create', [PostController::class, 'store'])->name('store');
    Route::post('/import-csv', [PostController::class, 'importCsv'])->name('import_csv');
});

Route::group([
    'prefix' => 'companies',
    'as'     => 'companies.',
], static function () {
    Route::post('/create', [CompanyController::class, 'store'])->name('store');
});
