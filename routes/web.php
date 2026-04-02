<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home'); 

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/flowers', function () {
    return view('flowers');
})->name('flowers');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/view-gallery', function () {
    return view('viewgallery');
})->name('gallery.view');