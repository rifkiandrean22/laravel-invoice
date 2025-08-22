<?php
use App\Http\Controllers\InvoiceController;

Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'downloadPdf'])
    ->name('invoice.download');

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
