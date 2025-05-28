<?php

use App\Events\testingEvent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload-endpoint', [FileController::class, 'store'])->name('file.upload');
