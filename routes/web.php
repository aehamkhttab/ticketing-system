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

//TODO: Add home page before login [home -> login or signup -> Tickets page ]


Route::get('/',function(){
    return redirect('auth/login');
});
Route::middleware('auth')->resource('/tickets', TicketController::class);



Route::prefix('auth')->group(function () {

    Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
    Route::post('/login', [AuthController::class, 'login'])->name('login');


    Route::get('/signup', [AuthController::class, 'signupView'])->name('signupView');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');


    Route::get('/forget-password', [AuthController::class, 'forgetPasswordView'])->name('forgetPasswordView');
    Route::post('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');

    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('resetPasswordView');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');


    Route::get('/attachments/download/{id}', [TicketController::class, 'downloadAttachment'])->name('attachments.download');
    Route::delete('/attachments/{id}', [TicketController::class, 'deleteAttachment'])->name('attachments.destroy');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

