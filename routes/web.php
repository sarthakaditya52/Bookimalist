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

/*Route::get('/', function () {
    return view('welcome');
});
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::match(['get','post'],'/admin','AdminController@login');

Route::get('/logout','AdminController@logout');
Route::group(['middleware'=>['auth']],function ()
{
    Route::get('/admin/dashboard','AdminController@dashboard');
    Route::get('/admin/settings','AdminController@settings');
    Route::get('/admin/check-pwd','AdminController@check_pwd');
    Route::match(['get','post'],'/admin/update-pwd','AdminController@update_pwd');

    //Main Categories(admin)
    Route::match(['get','post'],'/admin/add-maincategory','MainCategoryController@add');
    Route::match(['get','post'],'/admin/edit-maincategory/{id}','MainCategoryController@edit');
    Route::match(['get','post'],'/admin/delete-maincategory/{id}','MainCategoryController@delete');
    Route::match(['get','post'],'/admin/add-subcategory','SubCategoryController@add');
    Route::get('/admin/view-maincategories','MainCategoryController@view');

    //Books
    Route::match(['get','post'],'/admin/add-book','BooksController@add');
    Route::match(['get','post'],'/admin/add-books','BooksController@newadd');
    Route::match(['get','post'],'/admin/edit-book/{id}','BooksController@edit');
    Route::get('/admin/delete-book-image/{id}','BooksController@deleteImg');
    Route::get('/admin/delete-book/{id}','BooksController@delete');
    Route::get('/admin/view-books','BooksController@view');
    Route::match(['get','post'],'/admin/add-books-new','BooksController@newadd');
    //Route::get('/admin/add-books-new','BooksController@newadd');

    //Books Attributes
    Route::match(['post','get'],'admin/add-attributes/{id}','BooksController@addAttributes');
    Route::get('/admin/delete-attribute/{id}','BooksController@deleteAtr');

});
//Home Page
Route::get('/','IndexController@index');

//All Books Page
Route::get('/all-books','IndexController@allbooks');

//Category Pages
Route::get('/books/{url}','BooksController@books');
Route::match(['get','post'],'/single/{url}','BooksController@temp');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
