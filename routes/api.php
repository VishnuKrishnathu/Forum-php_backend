<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// protected routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/addLike', [PostController::class, 'addLike']);

    Route::delete('/addLike', [PostController::class, 'removeLike']);
});

Route::post('/signup', [Authentication::class, 'signUpHandler']);

Route::post('/login', [Authentication::class, 'loginHandler']);

Route::post('/ask-question', [PostController::class, 'askQuestion']);

Route::post('/get-questions', [PostController::class, 'allQuestions']);