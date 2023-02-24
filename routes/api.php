<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
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

//users


Route::post('/user/{user}',[ProfileController::class,'editProfile']);





Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('profile',[AuthController::class,'profile']);
    Route::get('categories', [CategoryController::class, 'index'])->middleware('permission:show category');
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


//Articles
Route::get('/articles',[ArticleController::class,'index'])->middleware('permission:show article');
Route::get('/articles/{id}',[ArticleController::class,'show'])->middleware('permission:show article');
Route::post('/articles',[ArticleController::class,'store'])->middleware('permission:add article');
Route::post('/articles/{id}',[ArticleController::class,'update'])->middleware('permission:edit my article | edit every article');
Route::post('/articles/{id}',[ArticleController::class,'destroy'])->middleware('delete article');
Route::get('/articles/search/{search}',[ArticleController::class,'search']);

// Categories
Route::post('categories', [CategoryController::class, 'store'])->middleware('permission:add category');
Route::get('category/{category}', [CategoryController::class, 'show'])->middleware('permission:show category');
Route::put('category/{category}', [CategoryController::class, 'update'])->middleware('permission:edit category');
Route::delete('category/{category}', [CategoryController::class, 'destroy'])->middleware('permission:delete category');

// Tags
Route::get('tags', [TagController::class, 'index'])->middleware('permission:show tag');
Route::post('tags', [TagController::class, 'store'])->middleware('permission:add tag');
Route::get('tag/{tag}', [TagController::class, 'show'])->middleware('permission:show tag');
Route::put('tag/{tag}', [TagController::class, 'update'])->middleware('permission:edit tag');
Route::delete('tag/{tag}', [TagController::class, 'destroy'])->middleware('permission:delete tag');

// Comments
Route::get('comments', [CommentController::class, 'index'])->middleware('permission:show comment');
Route::post('comments', [CommentController::class, 'store'])->middleware('permission:add comment');
Route::get('comments/{comment}', [CommentController::class, 'show'])->middleware('permission:show comment');
Route::put('comments/{comment}', [CommentController::class, 'update'])->middleware('edit my comment | edit every comment');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->middleware('delete my comment | edit every comment');




// Comments
//Route::apiResource('comments', CommentController::class);

//// Roles
//Route::get('roles', [RoleController::class, 'index']);
//Route::post('roles', [RoleController::class, 'store']);
//Route::get('roles/{role}', [RoleController::class, 'show']);
//Route::put('roles/{role}', [RoleController::class, 'update']);
//Route::delete('roles/{role}', [RoleController::class, 'destroy']);

