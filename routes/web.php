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
    return view('auth.login');
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/////////////////////////invoices/////////////////////////////
Route::group(['prefix' => 'invoices'], function () {
    Route::get('/', 'InvoicesController@index')->name('invoices');
    Route::get('create', 'InvoicesController@create')->name('invoices.create');
    Route::post('store', 'InvoicesController@store')->name('invoices.store');
   Route::post('destroy', 'InvoicesController@destroy')->name('invoices.destroy');
});



Route::get('section/{id}', 'InvoicesController@getproducts');

Route::post('/InvoicesDetails/{id}', 'Invoice_detailsController@index');
Route::get('/InvoicesDetails/{id}/{notifyId?}', 'InvoicesDetailsController@edit');
Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');
Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');
Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');


Route::get('/sections', 'SectionsController@index')->name('sections');
Route::post('/store', 'SectionsController@store')->name('sections.store');
Route::post('/update', 'SectionsController@update')->name('sections.update');
Route::delete('/destroy', 'SectionsController@destroy')->name('sections.destroy');


Route::get('/edit_invoice/{id}', 'InvoicesController@edit');
Route::post('/update_invoice', 'InvoicesController@Update')->name('invoices.update');
Route::get('/Status_show/{id}', 'InvoicesController@show')->name('Status_show');
Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');

Route::group(['prefix' => 'Archive'], function () {
    Route::get('/', 'InvoiceAchiveController@index');
    Route::post('update', 'InvoiceAchiveController@update')->name('Archive.update');
    Route::post('destroy', 'InvoiceAchiveController@destroy')->name('Archive.destroy');
});

Route::get('Invoice_Paid','InvoicesController@Invoice_Paid');

Route::get('Invoice_UnPaid','InvoicesController@Invoice_UnPaid');

Route::get('Invoice_Partial','InvoicesController@Invoice_Partial');
Route::get('Print_invoice/{id}','InvoicesController@Print_invoice');

/////////////////////////////products/////////////

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'ProductsController@index')->name('products.index');
    Route::post('store', 'ProductsController@store')->name('products.store');
    Route::post('destroy', 'ProductsController@destroy')->name('products.destroy');
    Route::post('update', 'ProductsController@update')->name('products.update');
});

Route::get('export_invoices','InvoicesController@export');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    //Route::resource('products','ProductController');
});

Route::get('invoices_report', 'Invoices_Report@index')->name("invoices_report");

Route::post('Search_invoices', 'Invoices_Report@Search_invoices');

Route::get('customers_report', 'Customers_Report@index')->name("customers_report");

Route::post('Search_customers', 'Customers_Report@Search_customers');

Route::get('MarkAsRead_all','InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');

Route::get('unreadNotifications_count', 'InvoicesController@unreadNotifications_count')->name('unreadNotifications_count');

Route::get('unreadNotifications', 'InvoicesController@unreadNotifications')->name('unreadNotifications');

Route::get('/{page}', 'AdminController@index');