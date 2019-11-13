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

Auth::routes();

Route::get("/check", function () {
    abort(404);
});
Route::post("/check", "HomeController@diagnosis_check")->name("check");
Route::get("/result", function () {
    abort(404);
});
Route::post("/result", "HomeController@diagnosis_result")->name("result");

Route::get("/communication/{alias}/{type}", "HomeController@diagnosis_comm")->name("comm");
Route::post("/communication/{alias}/{type}", function () {
    abort(404);
});

Route::get("/admin_", "AdminController@index")->name('admin_');
Route::get("/admin_/titles", "AdminController@titles")->name('admin_titles');
Route::get("/admin_/questions/{title_id}", "AdminController@questions")->name('admin_questions');
Route::get("/admin_/questions/edit/{title_id}/{no}", "AdminController@question_edit")->name('admin_question_edit');
Route::post("/admin_/questions/edit/{title_id}/{no}", "AdminController@question_edit_update");
Route::get("/admin_/types/{title_id}", "AdminController@types")->name("admin_types");
Route::get("/admin_/types/edit/{title_id}/{style}", "AdminController@type_edit")->name("admin_type_edit");
Route::post("/admin_/types/edit/{title_id}/{style}", "AdminController@type_edit_update");

Route::get("/admin_/logs", "AdminController@logs")->name('admin_logs');
Route::post("/admin_/logs", "AdminController@log_action");
Route::get("/admin_/logs_emails", "AdminController@logs_emails")->name("admin_logs_emails");

//Route::get("/admin_/email", "AdminController@emails")->name('admin_email');

Route::get('/admin_/mail_test/{pos?}', 'AdminMailController@mail_test')->name('admin_mail_test');
Route::post('/admin_/mail_test', function () {
    abort(404);
});
Route::post('/admin_/mail_send_test', 'AdminMailController@mail_send_test')->name('admin_send_test');
Route::get('/admin_/mail_send_test', function () {
    abort(404);
});
Route::post('/admin_/mail_edit', 'AdminMailController@mail_edit')->name('admin_mail_edit');
Route::get('/admin_/mail_edit', function () {
    abort(404);
});


Route::get('/save', function () {
    abort(404);
});
Route::post('/save', "HomeController@save")->name('save');

Route::get('/data_clear', "HomeController@data_clear")->name('clear');
Route::post('/data_clear', "HomeController@data_cleared");

Route::get("/{alias}", "HomeController@diagnosis")->name("diagnosis");
Route::post('/{alias}', function () {
    abort(404);
});
Route::get("/{alias}/{access_id}", "HomeController@user_result")->name('user_result');
Route::post('/{alias}/{access_id}', function () {
    abort(404);
});
Route::get("/{alias}/{access_id}/answer", "HomeController@user_answer")->name('user_answer');
Route::post('/{alias}/{access_id}', function () {
    abort(404);
});
