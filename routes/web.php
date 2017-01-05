<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


use Illuminate\Http\Request;

//First route that user visits on consumer app
Route::get('/', 'WelcomeController@index');
Route::get('/privacy', 'WelcomeController@privacy');
Route::get('/home', 'HomeController@index');
Route::get('/login', 'WelcomeController@index');
Route::get('/logout', 'HomeController@logout');

//Course
Route::get('/courses', 'CourseController@index');
Route::get('/course/{user}/{course}', 'CourseController@single');
Route::post('/course/remove', 'CourseController@remove');

//Quizzes
Route::get('/quiz/refresher', 'QuizController@refresher');
Route::post('/quiz/course', 'QuizController@course');

//Score
Route::post('/score/record', 'ScoreController@record');

//Social Logging
Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

//Public Search API
Route::get('/search/courses.json', 'SearchController@courses');
Route::get('/search/topic.json', 'SearchController@topics');
Route::post('/search/create/course', 'SearchController@createCourse');
Route::post('/search/create/courseById', 'SearchController@createCourseByID');
Route::post('/search/create/topic', 'SearchController@createTopic');


//Questions
Route::post('/question/create', 'QuestionsController@create');

Auth::routes();
