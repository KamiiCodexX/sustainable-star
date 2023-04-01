<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/companies', [App\Http\Controllers\CompanyController::class, 'index'])->name('companies');
Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
    // Route::get('/', ['as' => 'list', 'uses' => 'CompanyController@index']);
    Route::get('/', [App\Http\Controllers\CompanyController::class, 'index'])->name('list');
    Route::get('/get-companies', [App\Http\Controllers\CompanyController::class, 'getCompanies'])->name('get-companies');
    Route::get('/add', [App\Http\Controllers\CompanyController::class, 'add'])->name('add');
    Route::post('/store', [App\Http\Controllers\CompanyController::class, 'store'])->name('store');
    Route::post('/delete', [App\Http\Controllers\CompanyController::class, 'deleteCompanies'])->name('delete');
    Route::post('/storePermissions', [App\Http\Controllers\CompanyController::class, 'storePermissions'])->name('storePermissions');
    Route::post('/storeDelegates', [App\Http\Controllers\CompanyController::class, 'storeDelegates'])->name('storeDelegates');
    Route::post('/deleteDelegates', [App\Http\Controllers\CompanyController::class, 'deleteDelegates'])->name('deleteDelegates');

    // Route::get('/add', ['as' => 'add', 'uses' => 'CompanyController@index']);
    // Route::post('list-queries/json', ['as' => 'list_queries.json', 'uses' => 'CustomerQueriesController@listContactusQueriesJson']);
});

Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
    Route::post('/store', [App\Http\Controllers\PostController::class, 'store'])->name('store');
});
