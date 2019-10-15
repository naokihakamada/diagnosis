<?php

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


Route::get('/', 'HomeController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');


Route::get("/check", function () {
    abort(404);
});
Route::post("/check", "HomeController@diagnosis_check")->name("check");
Route::get("/result", function () {
    abort(404);
});
Route::post("/result", "HomeController@diagnosis_result")->name("result");

Route::get("/communication/{type}", "HomeController@diagnosis_comm")->name("comm");
Route::post("/communication/{type}", function () {
    abort(404);
});

Route::get("/admin_", "AdminController@index");

Route::get("/{alias}", "HomeController@diagnosis")->name("diagnosis");

Route::get('/save', function () {
    abort(404);
});
Route::post('/save', "HomeController@save")->name('save');

#Auth::routes();
