<?php

Route::apiResource('question', 'QuestionController');
Route::apiResource('question.reply', 'ReplyController');
Route::apiResource('category', 'CategoryController');

Route::post('question/{question}/reply/{reply}/like', 'ReplyController@like')->name('question.reply.like');
Route::delete('question/{question}/reply/{reply}/unlike', 'ReplyController@unlike')->name('question.reply.unlike');
