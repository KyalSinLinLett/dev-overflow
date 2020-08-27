<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//follow related routes
Route::post('/follow/{user}', 'FollowsController@store');

//profile related routes
Route::get('/profile/{user}', 'ProfileController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/{user}', 'ProfileController@update')->name('profile.update');

//post related routes
Route::post('/post', 'PostController@store')->name('post.store');
Route::get('/post/{post}', 'PostController@show');