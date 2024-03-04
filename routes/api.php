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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('reports')->group(function () {
    Route::controller(ReportController::class)->group(function (){
        /* CRUD */
        Route::post('/', 'index');
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/show', 'show');
        Route::post('/edit', 'edit');
        Route::post('/update', 'update');
        Route::post('/destroy', 'destroy');
    });
});

Route::prefix('crimes')->group(function () {
    Route::controller(CrimeController::class)->group(function (){
        /* CRUD */
        Route::post('/', 'index');
        Route::post('/create', 'create');
        Route::post('/store', 'store');
        Route::post('/show', 'show');
        Route::post('/edit', 'edit');
        Route::post('/update', 'update');
        Route::post('/destroy', 'destroy');
    });
});