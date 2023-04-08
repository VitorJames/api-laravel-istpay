<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CandidaturaController;

Route::prefix('vagas')->group(function () {
    Route::get('/', [VagaController::class, 'index']);
    Route::post('/', [VagaController::class, 'store']);
    Route::get('/{id}', [VagaController::class, 'show']);
    Route::put('/{id}', [VagaController::class, 'update']);
    Route::delete('/{id}', [VagaController::class, 'destroy']);
});

Route::prefix('candidatos')->group(function () {
    Route::get('/', [CandidatoController::class, 'index']);
    Route::post('/', [CandidatoController::class, 'store']);
    Route::get('/{id}', [CandidatoController::class, 'show']);
    Route::put('/{id}', [CandidatoController::class, 'update']);
    Route::delete('/{ids}', [CandidatoController::class, 'destroy']);
});

Route::prefix('candidaturas')->group(function () {
    Route::get('/', [CandidaturaController::class, 'index']);
    Route::post('/', [CandidaturaController::class, 'store']);
    Route::get('/{id}', [CandidaturaController::class, 'show']);
    Route::put('/{id}', [CandidaturaController::class, 'update']);
    Route::delete('/{ids}', [CandidaturaController::class, 'destroy']);
});
