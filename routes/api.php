<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('getUsers', 'listUsers');
    Route::get('listClients', 'listClients');
    Route::post('getuser/{id}', 'getEmail');
    Route::post('changepsw/{id}', 'changePassword');
    Route::post('forgotpsw', 'forgotPassword');
    Route::post('edit', 'editUser');
    Route::post('delete/{id}', 'deleteUser');
    Route::post('statusUsr', 'changeStatus');
    Route::get('CurrentDate', 'CurrentDate');
    
});

Route::controller(RoleController::class)->group(function () {
    Route::get('getRoles', 'listRoles');
    Route::post('addRole', 'create');
});
