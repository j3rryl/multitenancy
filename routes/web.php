<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IdentifyTenant;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/mark', [App\Http\Controllers\TestController::class, 'index'])->middleware(App\Http\Middleware\IdentifyTenant::class);

