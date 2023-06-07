<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// VERIFY OTP ALSO WORK AS A LOGIN IF USER EXISTS AND OTP VERIFIED  

Route::post('send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');
Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
Route::get('get-registration-form-data', [AuthController::class, 'getRegistrationFormData'])->name('get-registration-form-data');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('email-exist', [AuthController::class, 'emailExist'])->name('email-exist');
 
Route::middleware('auth:api')->group(function () {
    Route::get('get-user-profile/{id}', [CustomerController::class,'getProfile'])->name('get-user-profile');
    Route::post('update-user-profile', [CustomerController::class,'updateProfile'])->name('update-user-profile');
    Route::post('swipe-profile', [CustomerController::class,'swipeProfile'])->name('swipe-profile');
    Route::post('discover-profile', [CustomerController::class,'discoverProfile'])->name('discover-profile');
    Route::get('matched-user-list', [CustomerController::class,'matchedUserList'])->name('matched-user-list');
    Route::get('chat-list', [CustomerController::class,'chatList'])->name('chat-list');
    Route::post('change-read-status', [CustomerController::class,'changeReadStatus'])->name('change-read-status');
    Route::post('send-message', [CustomerController::class,'sendMessage'])->name('send-message');
    Route::post('unmatch', [CustomerController::class,'unmatch'])->name('unmatch');
    Route::post('report', [CustomerController::class,'report'])->name('report');
    Route::post('review-later', [CustomerController::class,'reviewLater'])->name('review-later');
    Route::get('get-undo-profile-data', [CustomerController::class,'undoProfile'])->name('undo-Profile');
    Route::get('who-viewed-me', [CustomerController::class,'whoViewedMe'])->name('who-viewed-me');
    Route::get('who-likes-me', [CustomerController::class,'whoLikesMe'])->name('who-likes-me');
    Route::get('review-later-list', [CustomerController::class,'reviewLaterList'])->name('review-later-list');
    Route::post('update-location', [CustomerController::class,'updateLocation'])->name('update-location');
    Route::post('single-video-call', [CustomerController::class,'singleVideoCall'])->name('single-video-call');
    Route::get('log-out', [CustomerController::class,'logout'])->name('log-out');
});