<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
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
Route::get('/', [MainController::class, 'Login'])->name('login');
Route::get('logout', [MainController::class, 'LogOut'])->name('logout');
Route::post('/do-login', [MainController::class, 'DoLogin'])->middleware('logincheck');


Route::get('/user', [MainController::class, 'UserDashBoard'])->middleware('usercheck')->name('user');
Route::get('mail-list', [MainController::class, 'MailList'])->middleware('usercheck')->name('mail-list');
Route::get('generate', [MainController::class, 'MailGenerate'])->middleware('usercheck');
Route::get('post/{id}', [MainController::class, 'MailPost'])->middleware('usercheck');
Route::post('mail-gen', [MainController::class, 'MailGen'])->middleware('usercheck');


Route::get('/admin', [AdminController::class, 'AdminDashBoard'])->middleware('admincheck')->name('admin');
Route::get('ad-mail-list', [AdminController::class, 'MailList'])->middleware('admincheck')->name('ad-mail-list');
Route::get('ad-mail-list-data', [AdminController::class, 'MailListData'])->middleware('admincheck')->name('ad-mail-list-data');
Route::get('user-list', [UserController::class, 'UserList'])->middleware('admincheck');
Route::get('mail-list-data', [UserController::class, 'MailListDataUser'])->middleware('usercheck')->name('mail-list-data');
Route::get('ad-mail-generate', [UserController::class, 'MailGenerate'])->middleware('admincheck');
Route::post('add-user', [UserController::class, 'UserAdd'])->middleware('admincheck');
Route::post('ad-mail-gen', [UserController::class, 'MailGen'])->middleware('admincheck');
Route::get('export', [UserController::class, 'ExportExcel']);
