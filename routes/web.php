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

Route::get('/', 'PostController@feed')->name('newsfeed');

Auth::routes();

//this route is just a workaround as of the moment to redirect the user to their profile page after login
//awaiting a better solution - help me??
Route::get('/home', 'HomeController@index')->name('home');

//comment related routes
Route::post('/comment/{post}', 'CommentController@store')->name('comment');
Route::get('/comment/{comment}/edit', 'CommentController@edit')->name('comment.edit');
Route::post('/comment/update/{comment}', 'CommentController@update')->name('comment.update');
Route::get('/comment/delete/{comment}', 'CommentController@delete')->name('comment.delete');

//follow related routes
Route::post('/follow/{user}', 'FollowsController@store');

//like related routes
Route::post('/like/{post}', 'LikeController@store');

//profile related routes
Route::get('/profile/{user}', 'ProfileController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/{user}', 'ProfileController@update')->name('profile.update');
Route::get('/profile/likedposts/{user}', 'ProfileController@viewLikedPosts')->name('profile.likedPosts');
Route::get('/profile/shared-posts/{user}', 'ProfileController@sharedPosts')->name('profile.sharedPosts');
Route::get('/profile/following/{user}', 'ProfileController@followingList')->name('profile.followingList');
Route::get('/profile/follower/{user}', 'ProfileController@followerList')->name('profile.followerList');

//post related routes
Route::post('/post', 'PostController@store')->name('post.store');
Route::get('/post/{post}', 'PostController@show')->name('post.show');
Route::get('/post/{post}/edit', 'PostController@edit')->name('post.edit');
Route::post('/post/{post}', 'PostController@update')->name('post.update');
Route::get('/post/{post}/delete', 'PostController@delete')->name('post.delete');
Route::get('/post/my-circle', 'PostController@privateFeed')->name('post.privatefeed');

//sharing posts related
Route::get('/post/{post}/share', 'PostController@sharePost')->name('post.share');
Route::get('/post/{post}/share-remove', 'PostController@shareRemove')->name('post.shareremove');

