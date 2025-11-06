<?php

use App\Http\Controllers\VideoController;
use App\Livewire\PaymentMethod;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// routes/web.php or routes/api.php
Route::get('/video/{filename}', [VideoController::class, 'stream'])->name('video.stream');
Route::get('/image/{filename}', [VideoController::class, 'thumbNail'])->name('image.show');

Route::get('/user/subscribe', function (Request $request) {
    // $request->user()->newSubscription(
    //     'default',
    //     'price_monthly'
    // )->create($request->paymentMethodId);

    // dd(Auth::user()->createAsStripeCustomer());

    Auth::user()->newSubscription(
        'default',
        'price_1SPmFcFSCQWDdTTExoiQbOMJ'
    )->create($request->paymentMethodId);

    // ...
});
