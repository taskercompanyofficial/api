<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\RedirectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/files', FilesController::class);

Route::group(['middleware' => ['guest']], function () {
    Route::post('/verify-campaign', [RedirectController::class, 'verifyCampaign'])->name('verify-campaign');

});

include 'crm-routes.php';
