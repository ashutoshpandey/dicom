<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'StaticController@home');
Route::get('/contact-us', 'StaticController@contactUs');
Route::get('/about-us', 'StaticController@aboutUs');
Route::get('/terms-and-conditions', 'StaticController@termsAndConditions');
Route::get('/privacy-policy', 'StaticController@privacyPolicy');

Route::get('/institutes', 'SearchController@institutes');
Route::get('/institute/{id}', 'SearchController@home');

Route::post('/is-valid-user', 'AuthenticationController@isValidUser');
Route::post('/is-valid-admin', 'AuthenticationController@isValidAdmin');

Route::get('/remove-user/{id}', 'PatientController@remove');

/********************** user urls ************************/

/********************** patient urls ************************/
Route::post('/save-patient', 'PatientController@savePatient');
Route::get('/remove-patient/{id}', 'PatientController@removePatient');
Route::get('/admin-get-patients/{page?}/{status?}', 'PatientController@getPatients');

/********************** admin urls ************************/
Route::get('/admin-login', 'AuthenticationController@adminLogin');
Route::get('/admin-section', 'AdminController@adminSection');
Route::get('/admin-institutes', 'AdminController@institutes');
Route::get('/admin-institute-experts/{id}', 'InstituteController@instituteExperts');
Route::get('/admin-patients', 'PatientController@patients');
Route::get('/admin-locations', 'LocationController@locations');

Route::get('/admin-list-institutes/{status}/{page}', 'InstituteController@adminListInstitutes');
Route::get('/admin-list-locations/{status}/{page}', 'AdminController@listLocations');

Route::get('/admin-view-institute/{id}', 'AdminController@viewInstitute');
Route::get('/admin-view-software-user/{id}', 'AdminController@viewSoftwareUser');
Route::get('/admin-view-user/{id}', 'AdminController@viewUser');

Route::get('/categories', 'CategoryController@categories');
Route::get('/subcategories/{id}', 'CategoryController@subcategories');

Route::get('/remove-location/{id}', 'LocationController@remove');
Route::get('/edit-location', 'LocationController@edit');
Route::post('/update-location', 'LocationController@update');
Route::post('/save-location', 'LocationController@save');

Route::get('/admin-users', 'UserController@manageUsers');
Route::post('/save-user', 'UserController@save');
Route::get('/edit-user', 'UserController@edit');
Route::post('/update-user', 'UserController@update');
Route::get('/get-user/{id}', 'UserController@getUser');
Route::get('/list-users/{status?}/{page?}', 'UserController@listUsers');
Route::get('/remove-user/{id}', 'UserController@remove');

Route::post('/save-institute', 'InstituteController@save');
Route::post('/save-institute-expert', 'InstituteController@saveExpert');
Route::get('/edit-institute', 'InstituteController@edit');
Route::post('/update-institute', 'InstituteController@update');
Route::get('/get-institute/{id}', 'InstituteController@getInstitute');
Route::get('/list-institutes/{page?}/{city?}/{country?}', 'InstituteController@listInstitutes');
Route::get('/admin-list-institute-experts/{page?}/{status?}', 'InstituteController@listExperts');
Route::get('/admin-view-institute-expert/{id}', 'InstituteController@viewExpert');
Route::get('/remove-institute/{id}', 'InstituteController@remove');
Route::get('/remove-institute-expert/{id}', 'InstituteController@removeExpert');

Route::get('/logout', 'AuthenticationController@logout');

Route::get('/admin-get-cities/{state}', 'AdminController@getCities');

Route::post('/assign-expert-category', 'AdminController@assignExpertCategory');
Route::get('/remove-expert-category/{id}', 'AdminController@removeExpertCategory');
Route::get('/admin-data-expert-categories/{id}/{status}', 'CategoryController@dataExpertCategories');

Route::get('/admin-categories', 'AdminController@manageCategories');
Route::get('/admin-list-categories/{status}', 'AdminController@listCategories');
Route::get('/admin-list-subcategories/{id}/{status}', 'AdminController@listSubcategories');
Route::post('/save-category', 'AdminController@saveCategory');
Route::post('/update-category', 'AdminController@updateCategory');
Route::post('/save-subcategory', 'AdminController@saveSubCategory');
Route::post('/update-subcategory', 'AdminController@updateSubCategory');
Route::get('/remove-category/{id}', 'AdminController@removeCategory');
Route::get('/remove-subcategory/{id}', 'AdminController@removeSubCategory');

Route::get('/data-expert-list-services/{id}/{page?}', 'ExpertController@dataListServices');
Route::get('/data-expert-list-qualification/{id}/{page?}', 'ExpertController@dataListQualification');
