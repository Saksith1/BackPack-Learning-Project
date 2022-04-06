<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileApi\PostController;
use App\Http\Controllers\MobileApi\CategoryController;
use App\Http\Controllers\MobileApi\TrainerController;
use App\Http\Controllers\MobileApi\UserController;

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
Route::group([
    // 'middleware' => 'auth:api',
    'prefix' => 'v1'
],function(){
    Route::resource('posts', PostController::class);
    Route::get('topic/{id}',[PostController::class, 'postsByCagegory']);
    Route::resource('users', UserController::class);
    Route::resource('categoires', CategoryController::class);
    Route::resource('trainers', TrainerController::class);
});
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'loginu']);

