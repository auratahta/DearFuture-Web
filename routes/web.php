<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', function () {
    return view('menu');
});

Route::get('/subjects', function () {
    return view('subjects');
});

Route::get('/find', function () {
    return view('find');
});

Route::get('/history', function () {
    return view('history');
});

Route::get('/profile', function () {
    return view('profile');
});