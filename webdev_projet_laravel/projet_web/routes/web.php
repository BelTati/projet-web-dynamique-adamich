<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostCategories;

/*
Route::get('/', function () {
    return view('home');
  
});
*/


Route::get('/', [PostCategories::class, 'index'])->name('home');
Route::get('service/{id}', [PostCategories::class, 'serviceDescription'])->name('service');
