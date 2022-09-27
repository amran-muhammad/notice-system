<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NoticeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('user/delete', [UserController::class, 'delete_user'])->middleware('auth:sanctum');
Route::post('user/create/new/teacher', [UserController::class, 'create_new_teacher'])->middleware('auth:sanctum');
Route::post('user/create/new/student', [UserController::class, 'create_new_student'])->middleware('auth:sanctum');
Route::post('user/update/data', [UserController::class, 'update_user'])->middleware('auth:sanctum');
Route::get('user/search', [UserController::class, 'find_a_user'])->middleware('auth:sanctum');
Route::get('teachers/all', [UserController::class, 'get_all_teacher'])->middleware('auth:sanctum');
Route::get('students/all', [UserController::class, 'get_all_student'])->middleware('auth:sanctum');

//Notices
Route::get('notices/all', [NoticeController::class, 'get_notices'])->middleware('auth:sanctum');
Route::post('notices/search', [NoticeController::class, 'search_notices'])->middleware('auth:sanctum');
Route::post('notices/file-upload', [NoticeController::class, 'file_upload'])->middleware('auth:sanctum');
Route::post('notices/create', [NoticeController::class, 'create_notice'])->middleware('auth:sanctum');
Route::put('notices/update', [NoticeController::class, 'update_notice'])->middleware('auth:sanctum');
Route::post('notices/delete', [NoticeController::class, 'delete_notice'])->middleware('auth:sanctum');

//Events
Route::get('events/all', [NoticeController::class, 'get_events']);
Route::post('events/file-upload', [NoticeController::class, 'event_file_upload'])->middleware('auth:sanctum');
Route::post('events/create', [NoticeController::class, 'create_event'])->middleware('auth:sanctum');
Route::put('events/update', [NoticeController::class, 'update_event'])->middleware('auth:sanctum');
Route::post('events/delete', [NoticeController::class, 'delete_event'])->middleware('auth:sanctum');


//Complain
Route::get('complains/all', [NoticeController::class, 'get_complains'])->middleware('auth:sanctum');
Route::post('complains/create', [NoticeController::class, 'create_complain'])->middleware('auth:sanctum');
Route::put('complains/update', [NoticeController::class, 'update_complain'])->middleware('auth:sanctum');
Route::delete('complains/delete', [NoticeController::class, 'delete_complain'])->middleware('auth:sanctum');
