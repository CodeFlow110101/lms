<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// routes/web.php or routes/api.php
Route::get('/video/{filename}', [VideoController::class, 'stream'])->name('video.stream');
Route::get('/image/{filename}', [VideoController::class, 'thumbNail'])->name('image.show');
