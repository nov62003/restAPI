<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post("/users", [UserController::class, "createUser"]);
Route::get("/users", [UserController::class, "getUsers"]);
