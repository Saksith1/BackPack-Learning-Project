<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CateogryController;

use App\Http\Controllers\TrainerController;
use App\Http\Controllers\MobileApi\UserController;
use App\Http\Controllers\MyAccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/category',[CateogryController::class,'index']);
Route::get('/api/category/{id}',[CateogryController::class,'show']);
Route::get('/api/trainer',[TrainerController::class,'getTrainer']);
Route::post('trainer/import', [TrainerController::class,'import']);
Route::post('admin/edit-account-info/change-proflile', [MyAccountController::class,'changeProfile']);


