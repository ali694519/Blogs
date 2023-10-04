<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\subscribersController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)
    ->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    // Route::post('refresh', 'refresh');
});


Route::middleware(['auth:api'])
    ->group(function () {
    Route::get('display/subscribers', [subscribersController::class, 'displayAllSubscribers']);
    Route::post('update/Subscriber/{id}', [subscribersController::class, 'updateSubscriber']);
    Route::post('delete/Subscriber/{id}', [subscribersController::class, 'deleteSubscriber']);
    Route::get('subscribers/trash',[subscribersController::class,'trash']);
    Route::post('subscribers/{id}/restore',[subscribersController::class,'restore']);
    Route::delete('subscribers/{id}/force-delete',[subscribersController::class,'forceDelete']);
    Route::get('filter',[subscribersController::class,'filter']);
});




Route::middleware(['auth:api'])
    ->group(function () {
    Route::get('AllBlogs', [BlogController::class, 'index']);
    Route::post('store/blogs', [BlogController::class, 'store']);
    Route::post('update/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('delete/blogs/{blog}', [BlogController::class, 'delete']);
    Route::get('blogs/trash',[BlogController::class,'trash']);
    Route::post('blogs/{id}/restore',[BlogController::class,'restore']);
    Route::delete('blogs/{id}/force-delete',[BlogController::class,'forceDelete']);
});
