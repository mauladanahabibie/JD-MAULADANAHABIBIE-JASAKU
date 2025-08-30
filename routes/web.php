<?php

use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JasaController;

Route::get('/', [JasaController::class, 'index'])->name('home');
Route::get('/layanan', function () {
    $categories = ServiceCategory::all();
    return view('layanan', compact('categories'));
})->name('layanan');