<?php

use App\Http\Controllers\JasaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JasaController::class, 'index'])->name('home');
