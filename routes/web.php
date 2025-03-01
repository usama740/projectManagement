<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd("web");
    return view('welcome');
});

