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

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/registration', function () {
    return view('registration');
})->name('registration');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/order', function () {
    return view('order');
})->name('order');