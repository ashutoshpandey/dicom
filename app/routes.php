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

Route::get('/login', 'AuthenticationController@login');
Route::post('/is-valid-user', 'AuthenticationController@isValidUser');

Route::get('/remove-user/{id}', 'PatientController@remove');

/********************** user urls ************************/

/********************** patient urls ************************/
Route::post('/save-patient', 'PatientController@savePatient');
Route::post('/update-institute-patient', 'PatientController@updateInstitutePatient');
Route::get('/remove-patient/{id}', 'PatientController@removePatient');
Route::get('/admin-get-patients/{page?}/{status?}', 'PatientController@getPatients');

/********************** admin urls ************************/
Route::get('/admin-login', 'AuthenticationController@adminLogin');
Route::post('/is-valid-admin', 'AuthenticationController@isValidAdmin');

Route::get('/admin-section', 'AdminController@adminSection');
Route::get('/admin-institutes', 'AdminController@institutes');
Route::get('/admin-institute-experts/{id}', 'InstituteController@instituteExperts');
Route::get('/admin-patients', 'PatientController@patients');
Route::get('/admin-locations', 'LocationController@locations');
Route::get('/admin-connections', 'ConnectionController@manageConnections');
Route::get('/admin-requests', 'RequestController@manageRequests');

Route::get('/admin-get-connections/{status?}/{page?}', 'ConnectionController@getConnections');
Route::post('/save-connection', 'ConnectionController@save');
Route::get('/remove-connection/{id}', 'ConnectionController@remove');

Route::get('/admin-list-institutes/{status}/{page}', 'InstituteController@adminListInstitutes');
Route::get('/admin-list-locations/{status}/{page}', 'AdminController@listLocations');

Route::get('/admin-view-institute/{id}', 'AdminController@viewInstitute');
Route::get('/admin-view-institute-patient/{id}', 'PatientController@viewInstitutePatient');

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
Route::get('/admin-view-user/{id}', 'UserController@viewUser');

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
Route::get('/data-get-patient/{id}', 'PatientController@dataGetPatient');
Route::get('/data-patient-documents/{id}', 'PatientController@dataPatientDocuments');

Route::get('/patient-requests', 'PatientController@patientRequests');
Route::get('/patient-request-history/{id}/{page?}/{status?}', 'PatientController@patientRequestHistory');

Route::get('/add-patient-request', 'PatientController@addPatientRequest');

Route::post('/forward-patient-request', 'PatientController@forwardPatientRequest');

Route::get('/patient-requests/{status?}', 'PatientController@patientRequests');

Route::get('/patient-request-forwards', 'PatientController@patientRequestForwards');

Route::get('/add-forward-patient-request-reply', 'PatientController@addForwardPatientRequestReply');

Route::get('/patient-request-forward-replies', 'PatientController@patientRequestForwardReplies');
