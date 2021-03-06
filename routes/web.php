<?php

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

Route::get('/', 'HomeController@index');

Route::group([
    'middleware' => 'admin'
], function (){

});

Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware' => 'admin'], function (){
    Route::get('/', 'DashboardController@index')->name('admin.index');
    Route::resource('/categories', 'CategoriesController');
    Route::resource('/tags', 'TagsController');
    Route::resource('/users', 'UsersController');
    Route::resource('/post', 'PostController');
    Route::get('/comments', 'CommentController@index');
    Route::get('/comments/toggle/{id}', 'CommentController@toggle');
    Route::delete('/comments/{id}', 'CommentController@destroy')->name('comment.destroy');
    Route::resource('/subscribers', 'SubscribersController');
});

Route::group(['middleware' => 'guest'], function (){
    Route::get('/register', 'AuthController@registerForm');
    Route::post('/register', 'AuthController@register');
    Route::get('/login', 'AuthController@loginForm')->name('login');
    Route::post('/login', 'AuthController@login');
});
Route::group(['middleware' => 'auth'], function (){
    Route::get('/logout', 'AuthController@logout');
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile', 'ProfileController@store');
    Route::post('/comment', 'CommentController@store');
});



Route::get('post/{slug}', 'HomeController@show')->name('post.show');
Route::get('tags/{slug}', 'HomeController@tag')->name('tag.show');
Route::get('categories/{slug}', 'HomeController@category')->name('category.show');
Route::post('/subscribe', 'SubsController@subscribe');
Route::get('/verify/{token}', 'SubsController@verify');


