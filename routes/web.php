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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/project', 'ProjectController@all')->name('projects');

Route::get('/project/add', 'ProjectController@add');
Route::post('/project/create', 'ProjectController@create');
Route::post('/project/edit/{project}', 'ProjectController@update');

Route::get('project/{project}', 'ProjectController@show');

Route::get('/home', 'HomeController@index')->name('home');
