<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

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


// Comments
Route::apiResource('comments', CommentController::class);

// Categories
Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories', [CategoryController::class, 'store']);
Route::get('category/{category}', [CategoryController::class, 'show']);
Route::put('category/{category}', [CategoryController::class, 'update']);
Route::delete('category/{category}', [CategoryController::class, 'destroy']);

// Tags
Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::get('tag/{tag}', [TagController::class, 'show']);
Route::put('tag/{tag}', [TagController::class, 'update']);
Route::delete('tag/{tag}', [TagController::class, 'destroy']);

