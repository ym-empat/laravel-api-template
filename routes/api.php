<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('/error', function () {
    throw new \Exception('My exception', rand(1000, 1999));

    return response()->json(['status' => 'ok']);
});
