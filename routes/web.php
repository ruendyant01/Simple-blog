<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::get("/", [BlogController::class, "index"])->name("home");
Route::post("/login", [LoginController::class, "login"]);
Route::post("/register", [RegisterController::class, "register"]);
Route::view("/login", "auth.login")->name("login");
Route::view("/register", "auth.register")->name("register");

Route::post("/logout", [LoginController::class,"logout"])->name("logout");
Route::view("/create", "blog.create");
Route::get("/{blog}/edit", [BlogController::class, "edit"]);
Route::post("/", [BlogController::class, "store"])->name("blog.create");

Route::resource("/tag", TagController::class);
Route::get("/{id}", [BlogController::class, "show"]);
Route::delete("/{id}", [BlogController::class, "destroy"]);
Route::patch("/{id}", [BlogController::class, "update"]);

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
