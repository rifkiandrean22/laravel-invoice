<?php
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'downloadPdf'])
    ->name('invoice.download');

Route::get('/signup', [RegisterController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.submit');

use App\Http\Controllers\FilamentRegisterController;

Route::get('/admin/signup', [FilamentRegisterController::class, 'showForm'])->name('filament.signup.form');
Route::post('/admin/signup', [FilamentRegisterController::class, 'register'])->name('filament.signup.submit');


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});
