<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagerController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/home/dashboard', 'HomeController@dashboard')->name('home.dashboard');

Route::resource('/products', 'ProductController');
Route::post('/products/filter', 'ProductController@filter')->name('products.filter');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@add')->name('cart.add');
Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{product}', 'CartController@remove')->name('cart.remove');
Route::delete('/cart', 'CartController@clear')->name('cart.clear');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');

// Laravel auth routes (login, register, logout, etc.)
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Admin routes
Route::get('/admin', 'AdminController@loginView')->name('admin');
Route::post('/admin/login', 'AdminController@login')->name('admin.login');
Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
Route::get('/admin/business', 'AdminController@business')->name('admin.business');
Route::get('/admin/business/{id}/edit', 'AdminController@editBusiness')->name('admin.editBusiness');
Route::patch('/admin/business/{id}', 'AdminController@updateBusiness')->name('admin.updateBusiness');
Route::delete('/admin/business/{id}', 'AdminController@deleteBusiness')->name('admin.deleteBusiness');
Route::get('/admin/newBusiness', 'AdminController@NewBusiness')->name('admin.newBusiness');
Route::post('/admin/AddBusiness', 'AdminController@AddBusiness')->name('admin.addBusiness');
Route::get('/admin/startImpersonate/{id}', 'AdminController@startImpersonate')->name('admin.startImpersonate');
Route::get('/admin/stopImpersonate', 'AdminController@stopImpersonate')->name('admin.stopImpersonate');
Route::get('/admin/passwordReset/{id}', 'AdminController@passwordReset')->name('admin.passwordReset');
Route::post('/admin/resetPassword/{id}', 'AdminController@resetPassword')->name('admin.resetPassword');

//user management
Route::get('/users/index', 'UserManagerController@index')->name('users.index');
Route::get('/users/addUser', 'UserManagerController@addUser')->name('users.addUser');
Route::post('/users/storeUser/{id}', 'UserManagerController@storeUser')->name('users.storeUser');
Route::get('/users/addRole', 'UserManagerController@addRole')->name('users.addRole');
Route::post('/users/storeRole', 'UserManagerController@storeRole')->name('users.storeRole');
Route::get('/users/editUser/{id}', 'UserManagerController@editUser')->name('users.editUser');
Route::get('/users/editRole/{id}', 'UserManagerController@editRole')->name('users.editRole');
Route::patch('/users/updateUser/{id}', 'UserManagerController@updateUser')->name('users.updateUser');
Route::patch('/users/updateRole/{id}', 'UserManagerController@updateRole')->name('users.updateRole');
Route::delete('/users/deleteUser/{id}', 'UserManagerController@deleteUser')->name('users.deleteUser');
Route::delete('/users/deleteRole/{id}', 'UserManagerController@deleteRole')->name('users.deleteRole');

Route::resource('/settings', 'SettingsController');

Route::resource('/notifications', 'NotificationsController');
