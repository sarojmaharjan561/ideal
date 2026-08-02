<?php

declare(strict_types=1);

use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/register', [RegisteredUserController::class, 'create']);
