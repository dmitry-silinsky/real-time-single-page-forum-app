<?php

Route::apiResource('question', 'QuestionController');
Route::apiResource('question.reply', 'ReplyController');
Route::apiResource('category', 'CategoryController');

Route::post('question/{question}/reply/{reply}/like', 'ReplyController@like')->name('question.reply.like');
Route::delete('question/{question}/reply/{reply}/unlike', 'ReplyController@unlike')->name('question.reply.unlike');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'as' => 'auth.',
], function ($router) {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
    Route::post('me', 'AuthController@me')->name('me');
    Route::post('signUp', 'AuthController@signUp')->name('signUp');
});
