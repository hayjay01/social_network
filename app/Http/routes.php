<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested. 
|
*/
/*
Home
*/
// plese wait let me confirm somthin

Route::get('/', [
	'uses' => '\Mysocial\Http\Controllers\HomeController@index',
	'as' => 'home',
	
]);

Route::get('/alert', function () {
	return redirect()->route('home')->with('info', 'You have signed up');
});

/*
Aunthentication and registration
*/
Route::get('/signup', [
	'uses'=>'\Mysocial\Http\Controllers\AuthController@getSignup',
	'as'=>'auth.signup',
	'middleware' =>['guest'],
	]);

Route::post('/signup', [
	'uses'=>'\Mysocial\Http\Controllers\AuthController@postSignup',
	'middleware' =>['guest'],
	]);

/*signing in*/
Route::get('/signin', [
	'uses'=>'\Mysocial\Http\Controllers\AuthController@getSignin',
	'as'=>'auth.signin',
	'middleware' =>['guest'],
	]);

Route::post('/signin', [
	'uses'=>'\Mysocial\Http\Controllers\AuthController@postSignin',
	'middleware' =>['guest'],
	]);

/*signing out*/
Route::get('/signout', [
	'uses'=>'\Mysocial\Http\Controllers\AuthController@getSignout',
	'as'=>'auth.signout',
	]);

/*search*/
Route::get('/search', [
	'uses'=>'\Mysocial\Http\Controllers\SearchController@getResults',
	'as'=>'search.results',
	]);

/*profile*/
Route::get('/user/{username}', [
	'uses'=>'\Mysocial\Http\Controllers\ProfileController@getProfile', 
	'as'=>'profile.index',
	]);

/*edit*/
Route::get('/profile/edit', [
	'uses'=>'\Mysocial\Http\Controllers\ProfileController@getEdit',
	'as'=>'profile.edit',
	'middleware'=>['auth'],
	]);

Route::post('/profile/edit', [
	'uses'=>'\Mysocial\Http\Controllers\ProfileController@postEdit',
	'middleware'=>['auth'],
	]);

/*friends*/
Route::get('/friends', [
	'uses'=>'\Mysocial\Http\Controllers\FriendController@getIndex',
	'as'=>'friends.index',
	'middleware'=>['auth'],
	]);

Route::get('/friends/add/{username}', [
	'uses'=>'\Mysocial\Http\Controllers\FriendController@getAdd',
	'as'=>'friends.add',
	'middleware'=>['auth'],
	]);

Route::get('/friends/accept/{username}', [
	'uses'=>'\Mysocial\Http\Controllers\FriendController@getAccept',
	'as'=>'friends.accept',
	'middleware'=>['auth'],
	]);

Route::post('/friends/delete/{username}', [
	'uses'=>'\Mysocial\Http\Controllers\FriendController@postDelete',
	'as'=>'friends.delete',
	'middleware'=>['auth'],
	]);

/*statuses*/
Route::post('/status/user', [
	'uses'=>'\Mysocial\Http\Controllers\StatusController@postStatus',
	'as'=>'status.post',
	'middleware'=>['auth'],
	]);

Route::post('/status/{statusId}/reply', [
	'uses'=>'\Mysocial\Http\Controllers\StatusController@postReply',
	'as'=>'status.reply',
	'middleware'=>['auth'],
	]); 

Route::get('/status/{statusId}/like', [
	'uses'=>'\Mysocial\Http\Controllers\StatusController@getLike',
	'as'=>'status.like',
	'middleware'=>['auth'],
	]);

Route::get('/status/{statusId}/dislike', [
	'uses'=>'\Mysocial\Http\Controllers\StatusController@getDisLike',
	'as'=>'status.dislike',
	'middleware'=>['auth'],
	]);


