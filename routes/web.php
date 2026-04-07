<?php

use App\Http\Controllers\DocsAccessController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DocsAccessController::class, 'showLoginForm'])->name('docs.login');
Route::post('/', [DocsAccessController::class, 'storeAccessToken'])->name('docs.login.submit');
Route::post('docs-logout', [DocsAccessController::class, 'logout'])->name('docs.logout');
