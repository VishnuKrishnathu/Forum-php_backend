<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\PostController;
use App\Models\Avatar;

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

/**
 * TODO: Need to add the other route to the auth:sanctu middleware
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// protected routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    // likes
    Route::post('/addLike', [PostController::class, 'addLike']);
    Route::delete('/addLike', [PostController::class, 'removeLike']);

    // comments routes
    Route::post('/add-comment', [PostController::class, 'addComment']);
    Route::post('/get-comments', [PostController::class, 'getComments']);

    // avatar routes
    Route::post('/change-avatar', [PostController::class, 'changeAvatar']);
    Route::get('/get-avatar', [PostController::class, 'getAvatar']);
});

Route::post('/signup', [Authentication::class, 'signUpHandler']);

Route::post('/login', [Authentication::class, 'loginHandler']);

Route::post('/ask-question', [PostController::class, 'askQuestion']);

Route::post('/get-questions', [PostController::class, 'allQuestions']);

