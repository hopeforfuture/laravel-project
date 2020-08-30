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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@index')->name('products.index');
    Route::get('/add', 'ProductsController@create')->name('products.add');
    Route::post('/insert', 'ProductsController@store')->name('products.insert');
    Route::get('/edit/{id}', 'ProductsController@edit')->name('products.edit');
    Route::post('/update/{id}', 'ProductsController@update')->name('products.update');
    Route::get('/delete/{id}', 'ProductsController@remove')->name('products.delete');
});

Route::prefix('students')->group(function() {
    Route::get('/', 'StudentController@index')->name('students.index');
    Route::get('/add', 'StudentController@create')->name('students.add');
    Route::post('/insert', 'StudentController@insert')->name('students.insert');
    Route::get('/edit/{id}', 'StudentController@edit')->name('students.edit');
    Route::post('/update/{id}', 'StudentController@update')->name('students.update');
    Route::get('/delete/{id}', 'StudentController@remove')->name('students.delete');
    Route::get('/view/{id}', 'StudentController@view')->name('students.view');
    Route::post('/roll/check', 'AjaxController@studentrollduplicate')->name('students.roll.duplicate');
});

Route::prefix('subjects')->group(function() {
    Route::get('/', 'SubjectController@index')->name('subjects.index');
    Route::get('/add', 'SubjectController@create')->name('subjects.add');
    Route::post('/insert', 'SubjectController@insert')->name('subjects.insert');
    Route::get('/edit/{id}', 'SubjectController@edit')->name('subjects.edit');
    Route::post('/update/{id}', 'SubjectController@update')->name('subjects.update');
    Route::get('/delete/{id}', 'SubjectController@remove')->name('subjects.delete');
});

Route::prefix('newscategory')->group(function() {
    Route::get('/', 'NewsCategoryController@index')->name('newscategory.index');
    Route::get('/add', 'NewsCategoryController@create')->name('newscategory.add');
    Route::post('/insert', 'NewsCategoryController@insert')->name('newscategory.insert');
    Route::get('/edit/{id}', 'NewsCategoryController@edit')->name('newscategory.edit');
    Route::post('/update/{id}', 'NewsCategoryController@update')->name('newscategory.update');
    Route::get('/delete/{id}', 'NewsCategoryController@remove')->name('newscategory.delete');
    Route::get('/export', 'NewsCategoryController@export')->name('newscategory.export');
    Route::post('/view', 'NewsCategoryController@view')->name('newscategory.view');
});

Route::prefix('news')->group(function() {
    Route::get('/', 'NewsController@index')->name('news.index');
    Route::get('/add', 'NewsController@create')->name('news.add');
    Route::post('/insert', 'NewsController@insert')->name('news.insert');
    Route::get('/edit/{id}', 'NewsController@edit')->name('news.edit');
    Route::post('/update/{id}', 'NewsController@update')->name('news.update');
    Route::get('/delete/{id}', 'NewsController@remove')->name('news.delete');
    Route::get('/export', 'NewsController@export')->name('news.export');
    Route::post('/view', 'NewsController@view')->name('news.view');
    Route::get('/search', 'NewsController@search')->name('news.search');
});

Route::prefix('article')->group(function() {
    Route::get('/', 'ArticleController@index')->name('article.index');
    Route::get('/add', 'ArticleController@create')->name('article.add');
    Route::post('/insert', 'ArticleController@insert')->name('article.insert');
    Route::get('/edit/{id}', 'ArticleController@edit')->name('article.edit');
    Route::post('/update/{id}', 'ArticleController@update')->name('article.update');
    Route::get('/delete/{id}', 'ArticleController@remove')->name('article.delete');
    Route::get('/export', 'ArticleController@export')->name('article.export');
    Route::post('/view', 'ArticleController@view')->name('article.view');
    Route::get('/search', 'ArticleController@search')->name('article.search');
    Route::get('/sessionset', 'ArticleController@setSession')->name('article.setSession');
    Route::get('/sessionget', 'ArticleController@getSession')->name('article.getsession');
    Route::get('/getArticleInfo/{id}', 'ArticleController@getArticleData_belongsTo')->name('laravel.belongto');
});

Route::prefix('eloquent')->group(function() {
    Route::get('/user/{id}', 'EloquentController@getUserData')->name('laravel.hasone');
    Route::get('/category/{id}/getposts', 'EloquentController@getPosts')->name('laravel.hasmany');
    Route::get('/user/{id}/getroles', 'EloquentController@getRoles')->name('laravel.manytomany');
});


Route::get('/newsitem', 'TestController@newslist')->name('newsitem.index');
Route::get('/sessionsetget', 'TestController@setsession')->name('session.example');

Route::get('/search', 'TestController@search')->name('search');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
