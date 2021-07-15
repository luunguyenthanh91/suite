<?php

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


/* Route::get('/', function () {
    return view('index.index');    
});*/
Route::group(['namespace' => 'Admin' , 'middleware' => ['adminAuth'] ], function () {

    // Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/',                                     'CompanyController@listDashboard')->name('dashboard.index');
    
});
Route::group(['namespace' => 'FE', 'middleware' => ['adminAuth'],  'prefix' => 'user'], function () {
   
});



/* Dashboard */
