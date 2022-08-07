<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChampionshipController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\PlayerTransferController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function (){
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resources([
        'championships' => ChampionshipController::class,
        'teams' => TeamController::class,
        'players' => PlayerController::class,
        'player-transfers' => PlayerTransferController::class
    ]);
});
