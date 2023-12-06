<?php

use App\Http\Controllers\API\RegisterController as APIRegisterController;
use App\Http\Controllers\API\ProdiController as APIProdiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\prodiController;
use App\Http\Controllers\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route:: post('register', [APIRegisterController::class, 'register']);
Route:: post('login', [ APIRegisterController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::apiResource("prodi", APIProdiController::class);
});

Route::middleware('auth:sanctum') ->post('/prodi/store', [ProdiController::class, 'store']);


