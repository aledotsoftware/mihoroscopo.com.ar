<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GoogleAdsController;

use App\Http\Controllers\SubscriptionController;

Route::prefix('v1')->group(function () {
    Route::prefix('notifications')->group(function () {
        Route::post('toQueue', [NotificationController::class, 'toQueue']);
    });


    Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

});
