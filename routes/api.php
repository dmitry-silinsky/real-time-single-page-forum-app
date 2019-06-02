<?php

Route::apiResource('question', 'QuestionController');
Route::apiResource('question.reply', 'ReplyController');
Route::apiResource('category', 'CategoryController');

Route::group(['prefix' => 'question/{question}/reply/{reply}', 'as' => 'question.reply'], function () {
    Route::post('like', 'ReplyController@like')->name('like');
    Route::delete('unlike', 'ReplyController@unlike')->name('unlike');
});

Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    Route::get('/', 'NotificationController@index')->name('index');
    Route::post('{notification}/mark-as-read', 'NotificationController@markAsRead')
        ->name('mark-as-read');
});

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
