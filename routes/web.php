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
Route::post('/like/{post}/{type}', 'LikeController@store');


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
Route::get('/my-circle', 'PostController@privateFeed')->name('post.privatefeed');

//sharing posts related
Route::get('/post/{post}/share', 'PostController@sharePost')->name('post.share');
Route::get('/post/{post}/share-remove', 'PostController@shareRemove')->name('post.shareremove');

//group related routes
Route::get('/group', 'GroupController@index')->name('group.index');
Route::get('/group/joined-groups', 'GroupController@joined_groups')->name('group.joined');
Route::post('/group/create', 'GroupController@create')->name('group.create');
Route::get('/group/join', 'GroupController@join')->name('group.join');
Route::get('/group/home/{group}', 'GroupController@home')->name('group.home');
Route::get('/group/edit/{group}', 'GroupController@edit')->name('group.edit');
Route::post('/group/update/{group}', 'GroupController@update')->name('group.update');
Route::get('/profile/member-groups/{user}', 'GroupController@g_member_profile')->name('profile.member-groups');
Route::get('/profile/created-groups/{user}', 'GroupController@g_create_profile')->name('profile.create-groups');

// -> group admin related routes
Route::get('/group/admin/post-panel/{group}', 'GroupController@post_panel')->name('group.post-panel');
Route::get('/group/admin/member-panel/{group}', 'GroupController@member_panel')->name('group.member-panel');
Route::get('/group/admin/admin-panel/{group}', 'GroupController@admin_panel')->name('group.admin-panel');
Route::get('/group/admin/make-admin/{member}/{group}', 'GroupController@make_admin')->name('group.makeadmin');
Route::get('/group/admin/remove-member/{member}/{group}', 'GroupController@remove_member')->name('group.remove-member');
Route::get('/group/admin/remove-admin/{admin}/{group}', 'GroupController@remove_admin')->name('group.remove-admin');
Route::get('/group/admin/approve-request/{group}/{user}/{notif}', 'GroupController@approve_request')->name('group.approve-request');

// -> group search member to add
Route::get('/group/member/search', 'GroupController@search_member')->name('group.member-search');

// -> group notifications related routes
Route::get('/group/join-request/{user}/{group}', 'GroupController@send_join_notification')->name('group.join-notif');
Route::get('/group/admin/request-panel/{group}', 'GroupController@join_requests')->name('group.requests-panel');
Route::get('/group/admin/cancel-request/{user}/{group}', 'GroupController@cancel_request')->name('group.cancel-request');
Route::get('/group/notifications', 'GroupController@noti')->name('group.noti');
Route::get('/group/mar/{notif}', 'GroupController@mark_as_read')->name('group.noti-mar');
Route::get('/group/rmv/{notif}', 'GroupController@remove_noti')->name('group.noti-rmv');

// -> group invite related routes
Route::get('/group/invite-public/{group}', 'GroupController@invite_public')->name('group.invite-public');
Route::get('/group/inv-pub/search', 'GroupController@public_invite_search');
Route::get('/grp/send-inv/pub/{sender}/{recipient}/{group}', 'GroupController@send_pub_invite_noti');
// make private invites also
Route::get('/group/inv-pri/search', 'GroupController@private_invite_search');
Route::get('/grp/send-inv/priv/{sender}/{recipient}/{group}', 'GroupController@send_priv_invite_noti');
Route::get('/group/accept-invite/{notif}', 'GroupController@accept_invite')->name('group.accept-invite-pri');

// -> group post related routes
Route::post('/group/create-post', 'GroupController@p_create')->name('group.create-post');
Route::get('/group/upload-docfiles/{group}', 'GroupController@upload_docfiles')->name('group.upload-docfiles');
Route::post('/group/save-docfiles/', 'GroupController@save_docfiles')->name('group.save-docfiles');
Route::get('/group/file-download/{file}', 'GroupController@file_download')->name('group.file-download');
Route::get('/group/edit/edit-post-img/{gp}', 'GroupController@p_edit_img')->name('group.groupPost-edit-img');
Route::get('/group/edit/edit-post-doc/{gp}', 'GroupController@p_edit_doc')->name('group.groupPost-edit-doc');
Route::post('/group/update-content-img', 'GroupController@p_update_content_img')->name('group.update-content-img');
Route::post('/group/update-content-doc', 'GroupController@p_update_content_doc')->name('group.update-content-doc');
Route::get('/group/remove-img/{file_name}/{gp}', 'GroupController@remove_img')->name('group.remove-img');
Route::get('/group/remove-doc/{file}/{gp}', 'GroupController@remove_doc')->name('group.remove-doc');
Route::get('/group/group-post/delete/{gp}', 'GroupController@delete_post')->name('group.groupPost-delete');
Route::get('/group/view-post/{gp}', 'GroupController@view_post')->name('group.view-post');

