<?php

use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\Auth\EmailVerificationPromptController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\VerifyEmailController;

use App\Http\Controllers\User\WeightController;
use App\Http\Controllers\User\HeightController;

use App\Http\Controllers\User\WeeklyController;
use App\Http\Controllers\User\MonthlyController;

use Illuminate\Support\Facades\Route;

use Spatie\Honeypot\ProtectAgainstSpam;


Route::get('/', function () {
    if(Auth::id()===null)
    {
        return view('user.welcome');
    }else{
        return redirect('/dashboard');
    }    
    // return view('user.welcome');
});

Route::get('/guesthelp', function () {
    if(Auth::id()===null)
    {
        return view('user.help');
    }else{
        return redirect('/help');
    }    
});

/*
Route::get('/dashboard', function () {
  return view('user.dashboard');
})->middleware(['auth:users'])->name('dashboard');
//Route::get('/weight', [WeightController::class, 'index'] )->middleware(['auth:users'])->name('dashboard');
Route::get('/weight', function () {
  return view('user.weight');
})->middleware(['auth:users'])->name('dashboard');
*/



Route::middleware(ProtectAgainstSpam::class)->group(function() {

Route::middleware(['auth:users'])->group(function () {
    $authName='dashboard';
//	Route::get('/weight', [WeightController::class, 'index'] )->name($authName);
    // ヘルプ
    Route::get('/help', function () {
        return view('user.help');
    })->name($authName);

    // 今日の記録
    Route::get('/weight', [WeightController::class, 'index'])->name($authName);
    // 身長の変更
    Route::get('/height', [HeightController::class, 'index'])->name($authName);

    // 今日の記録
    Route::post('/weight', [WeightController::class, 'post'])->name($authName);
    // 身長の変更
    Route::post('/height', [HeightController::class, 'post'])->name($authName);

    // 週の記録
    Route::get('/weekly', [WeeklyController::class, 'index'])->name($authName);
    // 月間の記録
    Route::get('/monthly', [MonthlyController::class, 'index'])->name($authName);	
});

Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware('guest')
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth:users')
                ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth:users', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth:users', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware('auth:users')
                ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware('auth:users');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth:users')
                ->name('logout');

});