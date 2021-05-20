<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\StudentAssignmentController;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () use ($router) {
    return response()->json(['msg' => 'Marijampolės Rygiškių Jono gimnazjos administracinės sistemos API'], 200);
});

Route::group(['prefix' => 'people'], function () {
    Route::get('/', ['as' => 'people.all', 'uses' => 'PeopleController@all']);
    Route::get('{id}', ['as' => 'people.show', 'uses' => 'PeopleController@show']);
    Route::post('/', ['as' => 'people.create', 'uses' => 'PeopleController@create']);
    Route::patch('update/{id}', ['as' => 'people.update', 'uses' => 'PeopleController@update']);
    Route::delete('{id}', ['as' => 'people.delete', 'uses' => 'PeopleController@destroy']);
});
Route::group(['prefix' => 'student'], function () {
    Route::get('/', ['as' => 'student.all', 'uses' => 'StudentController@all']);
    Route::get('{id}', ['as' => 'student.show', 'uses' => 'StudentController@show']);
    Route::post('/', ['as' => 'student.create', 'uses' => 'StudentController@create']);
    Route::delete('/{id}', ['as' => 'student.delete', 'uses' => 'StudentController@destroy']);
});
Route::group(['prefix' => 'teacher'], function () {
    Route::get('/', ['as' => 'teacher.all', 'uses' => 'TeacherController@all']);
    Route::get('{id}', ['as' => 'teacher.show', 'uses' => 'TeacherController@show']);
    Route::post('/', ['as' => 'teacher.create', 'uses' => 'TeacherController@create']);
    Route::patch('{id}', ['as' => 'teacher.update', 'uses' => 'TeacherController@update']);
    Route::delete('{id}', ['as' => 'teacher.delete', 'uses' => 'TeacherController@destroy']);
});
Route::group(['prefix' => 'parent'], function () {
    Route::get('/', ['as' => 'parent.all', 'uses' => 'ParentController@all']);
    Route::get('{id}', ['as' => 'parent.show', 'uses' => 'ParentController@show']);
    Route::post('/', ['as' => 'parent.create', 'uses' => 'ParentController@create']);
    Route::delete('/{id}', ['as' => 'parent.delete', 'uses' => 'ParentController@destroy']);
});
Route::group(['prefix' => 'class'], function () {
    Route::get('/', ['as' => 'class.all', 'uses' => 'ClassesController@all']);
    Route::get('{id}', ['as' => 'class.show', 'uses' => 'ClassesController@show']);
    Route::get('students/{id}', ['as' => 'class.students', 'uses' => 'ClassesController@showStudents']);
    Route::post('/', ['as' => 'class.create', 'uses' => 'ClassesController@create']);
    Route::post('schoolmaster/{id}', ['as' => 'class.assign', 'uses' => 'ClassesController@assignSchoolmaster']);
    Route::post('student', ['as' => 'class.assignStudent', 'uses' => 'ClassesController@assignStudent']);
    Route::post('student/all', ['as' => 'class.distributeAll', 'uses' => 'ClassesController@distributeAll']); //! Nerealizuota
    Route::post('update', ['as' => 'class.update', 'uses' => 'ClassesController@updateGroups']);
    Route::delete('/{id}', ['as' => 'class.delete', 'uses' => 'ClassesController@destroy']);
});
Route::group(['prefix' => 'subject'], function () {
    Route::get('/', ['as' => 'subject.all', 'uses' => 'SubjectController@all']);
    Route::get('{id}', ['as' => 'subject.show', 'uses' => 'SubjectController@show']);
    Route::post('/', ['as' => 'subject.create', 'uses' => 'SubjectController@create']);
    Route::delete('{id}', ['as' => 'subject.delete', 'uses' => 'SubjectController@destroy']);
});
Route::group(['prefix' => 'classroom'], function () {
    Route::get('/', ['as' => 'classroom.all', 'uses' => 'ClassroomController@all']);
    Route::get('{id}', ['as' => 'classroom.show', 'uses' => 'ClassroomController@show']);
    Route::post('/', ['as' => 'classroom.create', 'uses' => 'ClassroomController@create']);
    Route::patch('{id}', ['as' => 'classroom.update', 'uses' => 'ClassroomController@update']);
    Route::delete('{id}', ['as' => 'classroom.delete', 'uses' => 'ClassroomController@destroy']);
});
Route::group(['prefix' => 'grade'], function () {
    Route::get('/', ['as' => 'grades.all', 'uses' => 'GradesController@all']);
    Route::get('{id}', ['as' => 'grades.show', 'uses' => 'GradesController@show']);
    Route::post('/', ['as' => 'grades.create', 'uses' => 'GradesController@create']);
    //Route::patch('{id}', ['as' => 'grades.update', 'uses' => 'GradesController@update']);
    Route::delete('{id}', ['as' => 'grades.delete', 'uses' => 'GradesController@destroy']);
});
Route::group(['prefix' => 'stream'], function () {
    Route::get('/', ['as' => 'stream.all', 'uses' => 'StreamController@all']);
    Route::get('{id}', ['as' => 'stream.show', 'uses' => 'StreamController@show']);
    Route::post('/', ['as' => 'stream.create', 'uses' => 'StreamController@create']); //! Nerealizuota
    Route::delete('{id}', ['as' => 'stream.delete', 'uses' => 'StreamController@destroy']);
});
Route::group(['prefix' => 'sa'], function () { //! Nerealizuota
    Route::get('/', ['as' => 'sa.generate', 'uses' => 'StudentAssignmentController@generate']);
    Route::post('{id}', ['as' => 'sa.get', 'uses' => 'StudentAssignmentController@get']);
    Route::post('edit/{id}', ['as' => 'sa.get', 'uses' => 'StudentAssignmentController@edit']);
});
