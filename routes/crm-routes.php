<?php

use App\Http\Controllers\CRM\Authenticated\DomainsController;
use App\Http\Controllers\CRM\Authenticated\NetworksController;
use App\Http\Controllers\CRM\Authenticated\OfferController;
use App\Http\Controllers\CRM\Authenticated\StaffController;
use App\Http\Controllers\CRM\Authenticated\TrackersController;
use App\Http\Controllers\CRM\AUTHENTICATION\AuthenticatedSessionController;
use App\Http\Controllers\CRM\AUTHENTICATION\RegisterController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\RoutesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'crm'], function () {
    Route::group(['middleware' => ['guest']], function () {
        Route::post('/login', [AuthenticatedSessionController::class, 'store']);
        Route::post('/check-credentials', [AuthenticatedSessionController::class, 'check']);
        Route::post('/register', [RegisterController::class, 'store']);
        Route::get('/routes', [RoutesController::class, 'index']);
        Route::get('/options/{key}', [OptionsController::class, 'show']);
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/authenticated', function () {
            return 'Hello World authenticated';
        });
        Route::post('/routes', [RoutesController::class, 'store']);
        Route::put('/routes/{id}', [RoutesController::class, 'update']);
        Route::delete('/routes/{id}', [RoutesController::class, 'destroy']);
        Route::get('/routes/{id}', [RoutesController::class, 'show']);
        Route::apiResource('/options', OptionsController::class)->except(['show']);
        Route::apiResource('/domains', DomainsController::class);
        Route::apiResource('/trackers', TrackersController::class);
        Route::apiResource('/networks', NetworksController::class);
        Route::apiResource('/users', StaffController::class);
        Route::apiResource('/offers', OfferController::class);
    });
});
