<?php

use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\StaffAttendanceController;
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

// This login and logout route can be used by both admin and staff.
Route::post('/login', [StaffController::class, 'login']);
Route::get('/logout', [StaffController::class, 'logout'])->middleware(['auth:sanctum']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::apiResource('attendance', StaffAttendanceController::class);
});
