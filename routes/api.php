<?php

Route::group(['prefix' => 'v1', 'middleware' => ['cors']], function() {

    Route::get('polls', 'Api\PollController@index');
    Route::get('poll/{id}', 'Api\PollController@show');
    Route::post('save-poll-result', 'Api\PollController@saveResultPoll');

});

