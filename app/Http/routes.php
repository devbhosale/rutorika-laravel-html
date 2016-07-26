<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect()->route('order');
});

Route::get('order', ['as' => 'order', 'uses' => 'PagesController@getOrder']);
Route::post('order', ['as' => 'order-post', 'uses' => 'PagesController@postOrder']);

Route::get('image', ['as' => 'image', 'uses' => 'PagesController@getImage']);
Route::post('upload', [ 'as' => 'upload', 'uses' => '\Rutorika\Html\Http\UploadController@upload']);
