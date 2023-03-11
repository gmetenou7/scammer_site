<?php

use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/contact-us', function () {
    return view('contact');
})->name('contact-us');

Route::get('/forex', function () {
    return view('forex');
})->name('forex');

Route::get('/indices', function () {
    return view('indices');
})->name('indices');

Route::get('/shares', function () {
    return view('shares');
})->name('shares');

Route::get('/metals', function () {
    return view('metals');
})->name('metals');

Route::get('/energy', function () {
    return view('energy');
})->name('energy');

Route::get('/platform', function () {
    return view('platform');
})->name('platform');

Route::get('/accounts', function () {
    return view('accounts');
})->name('accounts');

Route::get('/charts', function () {
    return view('charts');
})->name('charts');

Route::get('/economic-calendar', function () {
    return view('economic-calendar');
})->name('economic-calendar');

Route::get('/heat-map', function () {
    return view('heat-map');
})->name('heat-map');

Route::get('/technical-analysis', function () {
    return view('technical-analysis');
})->name('technical-analysis');

Route::get('/autotrading', function () {
    return view('autotrading');
})->name('autotrading');

Route::get('/defence', function () {
    return view('defence');
})->name('defence');

Route::get('/no-commission', function () {
    return view('no-commission');
})->name('no-commission');

Route::get('/partnership', function () {
    return view('partnership');
})->name('partnership');

//For Admin
Route::middleware(['auth:sanctum','verified','authadmin'])->group(function(){
    Route::get('/admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');  
});

//For User or Customer
Route::middleware(['auth:sanctum','verified'])->group(function(){
    Route::get('/user/dashboard',UserDashboardComponent::class)->name('user.dashboard'); 
    });