<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LanguageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/posts/slug', [PostController::class, 'checkSlug'])->name('posts.slug.check');
Route::post('/posts/slug', [PostController::class, 'generateSlug'])->name('posts.slug.generate');
Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
Route::post('/companies/check', [CompanyController::class, 'check'])->name('companies.check');
Route::get('/languages', [LanguageController::class, 'index'])->name('languages');
