<?php

//use Illuminate\Http\Request;

Route::post('/register', 'AuthApi@register');
Route::post('/login', 'AuthApi@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/feed', 'FeedApi@feed');
    Route::post('/feed/create', 'FeedApi@create');
    Route::delete('/feed/delete', 'FeedApi@delete');
    //Comment
    Route::post('/comment/create', 'FeedApi@createComment');
    Route::post('/comment', 'FeedApi@getComment');
    Route::delete('/comment/delete', 'FeedApi@deleteComment');
    //Like
    Route::post('/like', 'LikeApi@like');
    Route::delete('/dislike', 'LikeApi@disLike');


});


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
