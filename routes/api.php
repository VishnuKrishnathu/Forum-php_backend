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

// Route::middleware('auth:sanctum')->get('/get-avatar', function(Request $request){
//         $avatar = Avatar::where('users_id', $request->user()->id)->select(
//             'seed', 'mouth', 'eyebrows',
//             'hair', 'eyes', 'nose',
//             'ears', 'shirt', 'earrings',
//             'glasses', 'facialHair', 'shirtColor',
//             'mouthColor', 'hairColor', 'glassesColor',
//             'facialHairColor', 'eyebrowColor', 'eyeShadowColor',
//             'earringColor', 'baseColor'
//         )->first();
//         if($avatar != NULL){
//             return $avatar;
//         }
//         else{
//             response
//         }

// });

// protected routes
Route::group(['middleware' => 'auth:sanctum'], function(){
    // likes
    Route::post('/addLike', [PostController::class, 'addLike']);
    Route::delete('/addLike', [PostController::class, 'removeLike']);

    // avatar routes
    Route::post('/change-avatar', [PostController::class, 'changeAvatar']);
    Route::get('/get-avatar', [PostController::class, 'getAvatar']);
});

Route::post('/signup', [Authentication::class, 'signUpHandler']);

Route::post('/login', [Authentication::class, 'loginHandler']);

Route::post('/ask-question', [PostController::class, 'askQuestion']);

Route::post('/get-questions', [PostController::class, 'allQuestions']);

