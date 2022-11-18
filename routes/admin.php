<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.master', ['title' => '']);
})->name('welcome');

Route::group([
    'prefix' => 'users',
    'as'     => 'users.',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
});
