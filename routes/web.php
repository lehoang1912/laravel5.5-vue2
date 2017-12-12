<?php

Route::any('{all}', function () {
    return view('index');
})->where(['all' => '.*']);
