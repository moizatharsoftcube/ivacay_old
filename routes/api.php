<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\ApiController;
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

//mz
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/hello', function(){
         dd(auth()->user()->tokens());
    });
    
    //UI Package
    Route::get('/package', [ApiController::class, 'index']);
    Route::get('/package-by-country/{id}', [ApiController::class, 'countryPackages']);
    Route::post('/search/{id}', [ApiController::class, 'search']);
    
    //UI Auth
    Route::post('/logout', [HomeController::class, 'logout']);


});
//mz

Route::post('/login', [HomeController::class, 'login']);
Route::get('/login-required', [HomeController::class, 'loginRequired'])->name('loginRequired');
Route::post('/register', [HomeController::class, 'register']);
Route::get('/country', [ApiController::class, 'country']);
