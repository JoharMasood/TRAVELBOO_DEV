<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login',  [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('ads', [\App\Http\Controllers\PostAdController::class, 'ads']);
Route::get('home',[\App\Http\Controllers\ShowAdsController::class,'showads']);
Route::get('detail',[\App\Http\Controllers\UserController::class,'userdetail']);
Route::get('myads',[\App\Http\Controllers\showAuthAdsController::class,'authads']);
Route::delete('delete-post/{id}',[\App\Http\Controllers\deleteAdsController::class,'destroy']);
Route::post('/ads/{id}', [\App\Http\Controllers\updateAdController::class, 'update']);
Route::post('/process-payment', [\App\Http\Controllers\TransactionController::class, 'makePayment']);
Route::post('/update-image', [\App\Http\Controllers\UpdateImageController::class, 'updateImage']);
Route::post('/post-contact', [\App\Http\Controllers\ContactController::class, 'contact']);
Route::get('/show-contact', [\App\Http\Controllers\ShowContactController::class, 'showContact']);
Route::post('/getpurchasedads', [\App\Http\Controllers\PurchasedAdController::class, 'index']);
Route::get('/check-transaction/{userId}/{adId}', [\App\Http\Controllers\CheckTransaction::class, 'checkTransaction']);
Route::get('/purchased-ads', [\App\Http\Controllers\UserPurchasedAds::class, 'purchasedAds']);
Route::get('/purchased-ads', [\App\Http\Controllers\UserPurchasedAds::class, 'purchasedAds']);
Route::put('/users/update', [\App\Http\Controllers\UserController::class, 'update']);
Route::post('/submitreview', [\App\Http\Controllers\ReviewController::class, 'handlereview']);
Route::get('/ratings/{user_id}', [\App\Http\Controllers\ShowReviewController::class, 'getRatingsAndComments']);
Route::get('/filterAndSortAds', [\App\Http\Controllers\filterAndSortAdsController::class, 'filterAndSortAds']);
Route::get('/users', [\App\Http\Controllers\ShowAllUserController::class, 'showuser']);
Route::delete('users/{id}', [\App\Http\Controllers\DeleteUserController::class,'destroy']);
Route::get('/usage-data', [\App\Http\Controllers\UsageDataController::class, 'index']);
Route::post('/usage-data', [\App\Http\Controllers\UsageDataController::class, 'store']);
Route::delete('/reviews', [\App\Http\Controllers\DeleteReviewController::class, 'deleteReview']);
Route::get('/admin-panel/reviews', [\App\Http\Controllers\AdminPanelReviewController::class, 'showreviews']);
Route::get('/random-reviews', [\App\Http\Controllers\RandomReviewsController::class, 'showRandomReviews']);
Route::get('/check-auth', [\App\Http\Controllers\CheckUserAuthController::class, 'checkAuth']);
Route::post('/refund-payment', [\App\Http\Controllers\RefundController::class, 'refundPayment']);
Route::get('/refunded-packages', [\App\Http\Controllers\ShowRefundedAdsController::class, 'refundedAds']);
Route::post('/refund-requests', [\App\Http\Controllers\HandleRefundRequestController::class, 'store']);
Route::get('/refund-requests', [\App\Http\Controllers\HandleRefundRequestController::class, 'index']);
//
//Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'unreadNotifications']);
//Route::patch('/notifications/markAsRead', [\App\Http\Controllers\NotificationController::class, 'markAsRead']);
//
//


