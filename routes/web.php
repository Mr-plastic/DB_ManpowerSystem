<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExecutiveController;
use App\Http\Controllers\DbController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\CarersController;
use App\Http\Controllers\CareStationController;
use App\Http\Controllers\CrossDataSearchController;
use App\Http\Controllers\AuthController;
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

Route::get('/', [ AuthController::class, 'show_login'])->name('login'); //讓login自訂義
Route::post('/post-login', [AuthController::class,'post_login']);
Route::get('/logout', [ AuthController::class, 'logout'])->name('logout'); //讓login自訂義
Route::get('/usersetting', [ AuthController::class, 'setting']);
Route::post('/add-user', [AuthController::class,'add_user'])->name('add-user');
Route::post('/show-edit-user', [AuthController::class,'show_edit_user'])->name('show-edit-user');
Route::post('/delete-user', [AuthController::class,'delete_user'])->name('delete-user');
//-----------------------------------------------
//秀executive
Route::get('/showexecutive',  [ExecutiveController::class, 'show_executive'])->middleware('auth');

//搜尋>65
Route::post('/post-areasearch',  [DbController::class, 'search_65_averageage'])->name('post-areasearch');

//新增executive
Route::post('/add-executive',  [ExecutiveController::class, 'add_executive'])->name('add-executive');

//info executive
Route::post('/info-executive',  [ExecutiveController::class, 'info_executive'])->name('info-executive');

//show edit executive
Route::post('/show-edit-executive',  [ExecutiveController::class, 'show_edit_executive'])->name('show-edit-executive');

//save edit executive
Route::post('/save-edit-executive',  [ExecutiveController::class, 'save_edit_executive'])->name('save-edit-executive');

//show search executive
Route::post('/show-search-executive',  [ExecutiveController::class, 'show_search_executive'])->name('show-search-executive');

//-----------------------------------------------

//-----------------------------------------------
//秀caredfamily
Route::get('/showcaredfamily',  [DbController::class, 'show_caredfamily'])->middleware('auth');

//新增cared family
Route::post('add-caredfamily',  [DbController::class, 'add_caredfamily'])->name('add-caredfamily');

//info cared family 
Route::post('info-caredfamily',  [DbController::class, 'info_caredfamily'])->name('info-caredfamily');

//show_edit cared family
Route::post('show-edit-caredfamily',  [DbController::class, 'show_edit_caredfamily'])->name('show-edit-caredfamily');

//save_edit cared family
Route::post('save-edit-caredfamily',  [DbController::class, 'save_edit_caredfamily'])->name('save-edit-caredfamily');

//搜尋cared_family家庭代碼，姓名 ajax
Route::post('search-caredfamily', [DbController::class, 'search_caredfamily'])->name('search_caredfamily');

//儲存search並儲存變更資料
Route::post('save-search-caredfamily', [DbController::class, 'save_search_caredfamily'])->name('save-search-caredfamily');
//-----------------------------------------------

//-----------------------------------------------
//秀carers
Route::get('/showcarers',  [CarersController::class, 'show_carers'])->middleware('auth');

//新增carers
Route::post('add-carers', [CarersController::class, 'add_carers'])->name('add-carers');

//info carers
Route::post('info-carers', [CarersController::class, 'info_carers'])->name('info-carers');

//show edit carers
Route::post('show-edit-carers', [CarersController::class, 'show_edit_carers'])->name('show-edit-carers');

//save edit carers
Route::post('save-edit-carers', [CarersController::class, 'save_edit_carers'])->name('save-edit-carers');

//show search carers
Route::post('show-search-carers', [CarersController::class, 'show_search_carers'])->name('show-search-carers');

//save search carers
Route::post('save-search-carers', [CarersController::class, 'save_search_carers'])->name('save-search-carers');
//-----------------------------------------------

//-----------------------------------------------
//秀care station
Route::get('/showcarestation',  [CareStationController::class, 'show_care_station'])->middleware('auth');
//add care station
Route::post('add-care-station', [CareStationController::class, 'add_care_station'])->name('add-care-station');

//show_edit care station
Route::post('show-edit-care-station', [CareStationController::class, 'show_edit_care_station'])->name('show-edit-care-station');

//save_edit care station
Route::post('save-edit-care-station', [CareStationController::class, 'save_edit_care_station'])->name('save-edit-care-station');

//show search care station
Route::post('show-search-care-station', [CareStationController::class, 'show_search_care_station'])->name('show-search-care-station');

//save search care station
Route::post('save-search-care-station', [CareStationController::class, 'save_search_care_station'])->name('save-search-care-station');

//return cross data search view
Route::get('crossdatasearch', [CrossDataSearchController::class, 'crossdatasearch'])->name('crossdatasearch')->middleware('auth');
//-----------------------------------------------
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
