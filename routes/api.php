<?php

Route::post('login', 'AuthenticationController@login');

Route::group(['middleware' => ['token.auth']], function () {
    Route::get('logout', 'AuthenticationController@logout');
});
