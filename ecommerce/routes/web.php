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

Route::get('/metrics', 'PrometheusController@metrics');
Route::get('/response', 'PrometheusController@responseTime');
Route::get('/counter', 'PrometheusController@counter');
Route::get('/gauge', 'PrometheusController@gauge');
