<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DateValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts']);


Route::get('/date-validation', [DateValidationController::class, 'showForm']);
Route::post('/date-validation', [DateValidationController::class, 'validateDates']);


