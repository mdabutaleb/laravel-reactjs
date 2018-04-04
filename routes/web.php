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

Route::get( '/', function () {
	return view( 'welcome' );
} );

Route::get( '/getMenu', 'HomeController@getMenu' ); //Menu
Route::get( '/gethomebanner', 'HomeController@getHomeBanner' ); //Home page banner video
Route::get( '/article/{section}/{slug}', 'HomeController@getHomeArticle' ); // Home page articles
Route::get( '/article/home-getting-started', 'HomeController@homeGettingStarted' ); // home page article
Route::get( '/testimonials', 'HomeController@getTestimonial' ); //Home page testimonials
Route::get( '/projects', 'HomeController@getProjects' ); //Project category with project in project page
Route::post( '/mail', 'HomeController@mail' ); // testing email subscription

Route::post('/community-user', 'HomeController@postCommunityUser'); //community user subscription
Route::post('/corporate-user', 'HomeController@postCorporateUser'); // corporate user subscription
Route::get('/about', 'HomeController@getAboutContent');
Route::get('/get-team-members', 'HomeController@getTeamMembers');
Route::get('/get-past-project', 'HomeController@getPastProject');