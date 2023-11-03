<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttendanceRecordController;
use App\Http\Controllers\Admin\RegisterStaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {
    Route::prefix('staff')->group(function() {
        Route::get('index', [RegisterStaffController::class, 'index']);
        Route::post('create', [RegisterStaffController::class, 'store']);
        Route::put('{id}/update', [RegisterStaffController::class, 'update']);
        Route::delete('{id}/delete', [RegisterStaffController::class, 'destroy']);
    });

    Route::apiResource('attendance', AttendanceRecordController::class);
});
