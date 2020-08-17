<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('currencies', 'CurrencyAPIController');

Route::apiResource('roles', 'RoleAPIController');

Route::apiResource('permissions', 'PermissionAPIController');

Route::apiResource('statuses', 'StatusAPIController');

Route::apiResource('length_units', 'LengthUnitAPIController');

Route::apiResource('levels', 'LevelAPIController');

Route::apiResource('course_sections', 'CourseSectionAPIController');

Route::apiResource('lessons', 'LessonAPIController');

Route::apiResource('adquired_skills', 'AdquiredSkillAPIController');

Route::apiResource('categories', 'CategoryAPIController');

Route::apiResource('courses', 'CourseAPIController');
Route::get('course/{slug}', 'CourseAPIController@showBySlug');
Route::get('courses-category/{slug}', 'CourseAPIController@getByCategorySlug');
Route::get('courses-destac', 'CourseAPIController@getCoursesDestac');

// Route::apiResource('accounts', 'AccountAPIController');