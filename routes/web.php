<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

/*Route::get('/' , [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{id}' , [TicketController::class, 'show'])->name('tickets.show');
Route::post('/tickets' , [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/create' , [TicketController::class, 'create'])->name('tickets.create');
Route::get('/tickets/{id}/edit' , [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{id}' , [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{id}/delete' , [TicketController::class, 'destroy'])->name('tickets.destroy');*/

Route::middleware('auth')->resource('/tickets', TicketController::class);
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
