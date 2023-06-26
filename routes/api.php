<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\ItemController;
use \App\Http\Controllers\ItemClassController;

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

######## GET #########
Route::get('users', [UserController::class, 'getUsers']);
Route::get('user/{id}', [UserController::class, 'getUser']);
Route::get('items', [ItemController::class, 'getItems']);
Route::get('item/{id}', [ItemController::class, 'getItem']);
Route::get('item', [ItemController::class, 'getItemByQueryParameters']);
Route::get('items-classes', [ItemClassController::class, 'getItemClasses']);
Route::get('items-class/{id}', [ItemClassController::class, 'getItemClass']);

######## POST #########
Route::post('users', [UserController::class, 'newUser']);
Route::post('users', [UserController::class, 'newUser']);
Route::post('items', [ItemController::class, 'newItem']);
Route::post('items-classes', [ItemClassController::class, 'newItemClass']);

###### PUT #########
Route::put('user/{id}', [UserController::class, 'updateUser']);
Route::put('item/{id}', [ItemController::class, 'updateItem']);
Route::get('items-class/{id}', [ItemClassController::class, 'updateItemsClass']);

###### DELETE #########
Route::delete('user/{id}', [UserController::class, 'deleteUser']);
Route::delete('item/{id}', [ItemController::class, 'deleteItem']);
Route::delete('items-class/{id}', [ItemClassController::class, 'deleteItemsClass']);
