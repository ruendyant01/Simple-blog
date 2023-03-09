<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", [BlogController::class, "index"]);
Route::view("/create", "blog.create");
Route::get("/{blog}/edit", [BlogController::class, "edit"]);
Route::post("/", [BlogController::class, "store"]);

Route::resource("/tag", TagController::class);
Route::get("/{id}", [BlogController::class, "show"]);
Route::delete("/{id}", [BlogController::class, "destroy"]);
Route::patch("/{id}", [BlogController::class, "update"]);
