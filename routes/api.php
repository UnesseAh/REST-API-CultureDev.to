<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\resetPasswordController;
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

// Users
Route::post('/user/{user}',[ProfileController::class,'editProfile']);
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::post('forgot-password', [resetPasswordController::class,'sendResetToken'])->middleware('guest')->name('password.email');
Route::post('reset-password', [resetPasswordController::class,'resetPassword'])->middleware('guest')->name('password.update');
Route::get('reset-password/{token}', function (string $token) {
    return $token;
})->middleware('guest')->name('password.reset');




Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('profile',[AuthController::class,'profile']);
    //Articles
    Route::group(['controller' => ArticleController::class], function (){
        Route::post('/articles','store')->middleware('permission:add article');
        Route::put('articles/{id}','update')->middleware('permission:edit my article|edit every article');
        Route::post('/articles/{id}','destroy')->middleware('delete article');
    });
    // Categories
    Route::group(['controller' => CategoryController::class], function (){
        Route::get('categories','index')->middleware('permission:show category');
        Route::post('categories','store')->middleware('permission:add category');
        Route::get('category/{category}','show')->middleware('permission:show category');
        Route::put('category/{category}','update')->middleware('permission:edit category');
        Route::delete('category/{category}','destroy')->middleware('permission:delete category');
    });
    // Tags
    Route::group(['controller' => TagController::class], function (){
        Route::get('tags','index')->middleware('permission:show tag');
        Route::post('tags','store')->middleware('permission:add tag');
        Route::get('tag/{tag}','show')->middleware('permission:show tag');
        Route::put('tag/{tag}','update')->middleware('permission:edit tag');
        Route::delete('tag/{tag}','destroy')->middleware('permission:delete tag');
    });
    // Comments
    Route::group(['controller' => CommentController::class], function (){
        Route::get('comments','index')->middleware('permission:show comment');
        Route::post('comments','store')->middleware('permission:add comment');
        Route::get('comments/{comment}','show')->middleware('permission:show comment');
        Route::put('comments/{comment}','update')->middleware('permission:edit my comment|edit every comment');
        Route::delete('comments/{comment}','destroy')->middleware('permission:delete my comment|delete every comment');
    });
    // Roles
    Route::group(['controller' => RoleController::class], function (){
        Route::get('roles','index')->middleware('permission:show role');
        Route::post('roles','store')->middleware('permission:add role');
        Route::get('roles/{role}','show')->middleware('permission:show role');
        Route::put('roles/{role}','update')->middleware('permission:edit role');
        Route::delete('roles/{role}','destroy')->middleware('permission:delete role');
    });
    // Search
    Route::get('/articles/search/{search}',[ArticleController::class,'search']);
});

Route::group(['controller' => ArticleController::class], function (){
    Route::get('/articles','index');
    Route::get('/articles/{id}','show');
});


