<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('users', 'UsersController');
Route::resource('microposts', 'MicropostsController');
Route::resource('relationships', 'RelationshipsController');
Route::get('/register', array(
  'uses' => 'UsersController@create',
  'as' => 'users.create'
));

Route::get('login', array(
  'uses' => 'SessionController@create',
  'as' => 'session.create'
));
Route::post('login', array(
  'uses' => 'SessionController@store',
  'as' => 'session.store'
));
Route::get('logout', array(
  'uses' => 'SessionController@destroy',
  'as' => 'session.destroy'
));

/**
 * Home (Feed)
 */
Route::get('/', array(
  'uses' => 'HomeController@index',
  'as' => 'home.index'
));
Route::get('feed', array(
  'before' => 'auth',
  'uses' => 'HomeController@index',
  'as' => 'home.feed'
));
Route::get('/about', array(
  'uses' => 'HomeController@about',
  'as' => 'home.about'
));
