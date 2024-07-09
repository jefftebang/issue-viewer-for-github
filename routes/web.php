<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;

// Authentication
Route::get('/auth/redirect', [LoginController::class, 'loginRedirect'])->name('loginViaGitHub');
Route::get('/auth/callback', [LoginController::class, 'loginCallback']);
Route::get('/auth/user', [LoginController::class, 'getAndSaveUser'])->name('userSave');
Route::get('/auth/logout', [LoginController::class, 'logOutUser'])->name('logout');

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Issue view details page
Route::get('/repos/{repo}/issues/{issueNumber}', [IssueController::class, "index"]);