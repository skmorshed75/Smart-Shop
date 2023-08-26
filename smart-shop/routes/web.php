<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVerificationMiddleware;


//API Routes
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class, 'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
//Token Verification
Route::post('/reset-password',[UserController::class,'ResetPassword'])
    ->middleware([TokenVerificationMiddleware::class]); 

Route::get('user-profile',[UserController::class,'UserProfile'])
    ->middleware([TokenVerificationMiddleware::class]);
Route::post('user-update',[UserController::class,'UpdateProfile'])
    ->middleware([TokenVerificationMiddleware::class]);


//User Logout
Route::get('/user-logout',[UserController::class,'UserLogout']);

//Page Routes
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOtpPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage']);

Route::get('/dashboard',[DashboardController::class,'DashboardPage'])
->middleware([TokenVerificationMiddleware::class]);

Route::get('/userProfile',[UserController::class,'ProfilePage'])
    ->middleware([TokenVerificationMiddleware::class]);
