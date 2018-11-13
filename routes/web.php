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

Route::get('admin/login', 'AdminLoginController@getlogin');
Route::post('admin/login', 'AdminLoginController@postlogin');
Route::get('admin/logout', 'AdminLoginController@logout')->name('admin.logout');

// Admin side
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::resource('roles', 'RoleController', ['except' => ['show']]);
    Route::resource('users', 'UserController');
    Route::resource('categories', 'CategoryController', ['except' => ['show']]);
    Route::resource('topics', 'TopicController');
    Route::resource('questions', 'QuestionController');
    Route::get('select-ajax/{category_id}', 'SelectAjaxController@select');
});

// Client side
Auth::routes();
Route::get('/', 'HomePageController@home');
Route::view('about', 'pages.about');
Route::view('contact', 'pages.contact');

// Comment 
Route::get('comments/{question}', 'HomePageController@comments')->name('comments');

// OAuth Routes (Social)
Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.oauth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');

// User's profile
Route::get('profile/{username}/{user}', 'HomePageController@getProfile')->name('user.profile');
Route::post('profile/{username}/{user}', 'HomePageController@postProfile')->name('user.update');

// User create topics
Route::get('create-topics/create', 'UserCreateTopicController@create')->name('create-topics.create');
Route::get('create-topics/{user}', 'UserCreateTopicController@index')->name('create-topics.index');
Route::get('create-topics/{category}/{topic}/{id}', 'UserCreateTopicController@show')->name('create-topics.show');
Route::resource('create-topics', 'UserCreateTopicController', ['except' => ['index','create', 'show']]);

// Register
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

// Logout
Route::get('logout', 'HomePageController@logout')->name('logout');

// handle ajax
Route::get('category/{category_id}', 'QuizController@category');

// Quiz page
Route::get('{category}/{topic}', 'QuizController@quiz')->name('quiz');

Route::get('{category}/{topic}/{id}', 'QuizController@reviewQuiz')->name('review');

// handle question
Route::get('question', 'QuizController@handleQuestion');

// Like
Route::post('like', 'LikeController@likeTopic')->name('like');
