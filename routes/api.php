<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TicketController;
use App\Http\Controllers\api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:api')->group(function () {
    Route::get('',[TicketController::class, 'index']);
    Route::post('/', [TicketController::class, 'store']);
    Route::get('/{id}', [TicketController::class, 'show']);
    Route::put('/{id}', [TicketController::class, 'update']);
    Route::delete('/{id}', [TicketController::class, 'destroy']);
    Route::post('/deleted-tickets' , [TicketController::class, 'showTrashedTickets']);
    Route::post('/deleted-tickets/{id}' , [TicketController::class, 'restoreTrashedTickets']);

})->prefix('tickets');


Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/signup', [AuthController::class, 'signup']);
Route::post('auth/logout', [AuthController::class, 'logout']);
