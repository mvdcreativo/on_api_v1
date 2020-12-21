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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::post('signup', 'Auth\AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::get('user', 'Auth\AuthController@user');

        // Route::apiResource('users', 'UserAPIController');
    });



});
Route::post('social-auth', 'Auth\SocialAuthController@loginSocial');


Route::apiResource('users', 'UserAPIController');


Route::apiResource('orders', 'OrderAPIController');

Route::get('enrollments', 'EnrollmentAPIController@indexEnrollments');

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

Route::apiResource('schedules', 'ScheduleAPIController');


Route::apiResource('courses', 'CourseAPIController');
Route::post('clone', 'CourseAPIController@clone');
Route::get('user_courses/{id}', 'UserAPIController@user_courses');
Route::get('check-email-exist/{email}', 'UserAPIController@checkEmailExist');
Route::get('course/{slug}', 'CourseAPIController@showBySlug');
Route::get('courses-category/{slug}', 'CourseAPIController@getByCategorySlug');
Route::get('courses-destac', 'CourseAPIController@getCoursesDestac');
// Route::get('instructors', 'UserAPIController@get_user_instructors');
Route::apiResource('accounts', 'AccountAPIController');
Route::apiResource('instructors', 'InstructorAPIController');
Route::get('courses_instructor', 'InstructorAPIController@courses_instructor');
Route::apiResource('students', 'StudentAPIController');
Route::apiResource('states', 'StateAPIController');
Route::apiResource('cities', 'CityAPIController');
Route::apiResource('neighborhoods', 'NeighborhoodAPIController');

// Route::get('instructors', 'InstructorAPIController');

Route::put('course_sections_sort','CourseSectionAPIController@sort_section');
Route::put('lessons_sort','LessonAPIController@sort_lesson');


Route::group(['prefix' => 'exports'], function () {
    ///Exports
    Route::get('student_course', 'OrderAPIController@export_students_course_excel');
  

});
