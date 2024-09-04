<?php

use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("create-menu", [MenuController::class, "createMenu"]);
Route::get("get-menus", [MenuController::class, "getMenu"]);
