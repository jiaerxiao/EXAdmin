<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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


//登录注册相关
Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('register', 'register');
    Route::post('password', 'password');
});

//图形验证码
Route::get('captcha', CaptchaController::class);


//上传
Route::post('upload/image', [UploadController::class, 'image']);

//用户
Route::get('user/info', [UserController::class, 'info']);
Route::post('user/mobile', [UserController::class, 'mobile']);
Route::apiResource('user', UserController::class);

//角色和权限
Route::apiResource('role', RoleController::class);
Route::apiResource('permission', PermissionController::class);
