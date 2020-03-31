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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => true, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::get('/home', 'HomeController@index');
Route::get('/smtp', 'HomeController@smtp');
Route::post('/update/connection', 'SmtpController@update');
Route::post('/delete/connection', 'SmtpController@delete');
Route::post('/activate/connection', 'SmtpController@activate');
Route::get('/jobs', 'HomeController@jobs');
Route::post('/job', 'Jobs@create');

Route::get('mailable', function () {

    return new \App\Mail\Welcome();
});