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
Route::get('/courses/{institute_id}', 'CourseController@courses');
Route::get('/course/{id}', 'CourseController@course');
Route::get('/products/{course_id}', 'ProductController@products');
Route::post('/get-course-products/{subjects?}', 'ProductController@getProducts');
Route::get('/product/{id}', 'ProductController@product');

Route::get('/add-to-bag/{id}/{quantity}', 'CartController@addToBag');
Route::get('/get-bag', 'CartController@getBag');
Route::get('/bag', 'CartController@bag');
Route::get('/remove-from-bag/{id}', 'CartController@removeFromBag');
Route::get('/save-order', 'CartController@saveOrder');

Route::get('/checkout-login', 'CheckoutController@login');
Route::get('/checkout-guest', 'CheckoutController@guest');
Route::get('/checkout-address', 'CheckoutController@address');
Route::post('/checkout-update-address', 'CheckoutController@updateAddress');
Route::get('/checkout-payment', 'CheckoutController@payment');
Route::any('/transaction-success', 'CheckoutController@transactionSuccess');
Route::any('/transaction-failure', 'CheckoutController@transactionFailure');

Route::post('/is-valid-user', 'AuthenticationController@isValidUser');
Route::post('/is-valid-checkout-user', 'CheckoutController@isValidUser');

Route::get('/admin-login', 'AuthenticationController@adminLogin');
Route::post('/is-valid-admin', 'AuthenticationController@isValidAdmin');

Route::get('/get-courses/{id}', 'InstituteController@getCourses');
Route::get('/get-course-products/{id}', 'CourseController@getCourseProducts');
Route::get('/remove-course/{id}', 'CourseController@remove');
Route::get('/edit-course', 'CourseController@edit');
Route::post('/update-course', 'CourseController@update');
Route::post('/save-course', 'CourseController@save');

Route::get('/remove-product/{id}', 'ProductController@remove');
Route::get('/edit-product', 'ProductController@edit');
Route::post('/update-product', 'ProductController@update');
Route::post('/save-product', 'ProductController@save');

Route::get('/remove-user/{id}', 'UserController@remove');

Route::get('/search-cities/{key}', 'SearchController@searchCities');
Route::get('/search-keyword/{key}/{city_id?}', 'SearchController@searchByKeyword');

/********************** user urls ************************/

Route::get('/user-section', 'UserController@userSection');
Route::get('/user-orders', 'UserController@orders');
Route::get('/get-user-orders/{status?}/{page?}/{startDate?}/{endDate?}', 'UserController@getUserOrders');
Route::get('/user-order/{id}', 'UserController@order');
Route::get('/user-profile', 'UserController@profile');
Route::post('/update-user-profile', 'UserController@updateProfile');
Route::post('/update-user-password', 'UserController@updatePassword');
Route::get('/complaint', 'UserController@complaint');
Route::post('/submit-complaint', 'UserController@submitComplaint');
Route::post('/complaint-status', 'UserController@complaintStatus');

/********************** complaint urls ************************/

Route::get('/manage-complaints', 'ComplaintController@manage');
Route::get('/get-complaint/{id}', 'ComplaintController@getComplaint');
Route::get('/get-complaint-updates', 'ComplaintController@complaintUpdates');
Route::post('/save-complaint', 'ComplaintController@save');
Route::post('/update-complaint-personal', 'ComplaintController@updatePersonal');
Route::post('/add-complaint-update', 'ComplaintController@addComplaintUpdate');
Route::get('/pending-complaints/{page?}', 'ComplaintController@pendingComplaints');
Route::get('/software-user-complaints/{id}', 'ComplaintController@softwareUserComplaints');
Route::get('/admin-view-complaint/{id}', 'ComplaintController@view');
Route::get('/resolve-complaint/{id}', 'ComplaintController@resolve');

/********************** admin urls ************************/
Route::get('/admin-section', 'AdminController@adminSection');
Route::get('/admin-institutes', 'AdminController@institutes');
Route::get('/admin-courses/{id}', 'AdminController@courses');
Route::get('/admin-products/{id}', 'AdminController@products');
Route::get('/admin-orders', 'AdminController@orders');
Route::get('/admin-couriers', 'AdminController@couriers');
Route::get('/admin-users', 'AdminController@users');
Route::get('/admin-software-users', 'AdminController@softwareUsers');
Route::get('/admin-locations', 'LocationController@locations');

Route::get('/admin-list-institutes/{status}/{page}', 'InstituteController@adminListInstitutes');
Route::get('/admin-list-orders/{status}/{page}', 'AdminController@listOrders');
Route::get('/admin-list-courses/{status}/{page}', 'AdminController@listCourses');
Route::get('/admin-list-products/{status}/{page}', 'AdminController@listProducts');
Route::get('/admin-list-couriers/{status}/{page}', 'AdminController@listCouriers');
Route::get('/admin-list-software-users/{status}/{page}', 'AdminController@listSoftwareUsers');
Route::get('/admin-list-users/{status}/{page}', 'AdminController@listUsers');
Route::get('/admin-list-locations/{status}/{page}', 'AdminController@listLocations');

Route::get('/admin-view-institute/{id}', 'AdminController@viewInstitute');
Route::get('/admin-view-course/{id}', 'AdminController@viewCourse');
Route::get('/admin-view-product/{id}', 'AdminController@viewProduct');
Route::get('/admin-view-courier/{id}', 'AdminController@viewCourier');
Route::get('/admin-view-software-user/{id}', 'AdminController@viewSoftwareUser');
Route::get('/admin-view-user/{id}', 'AdminController@viewUser');
Route::get('/admin-view-location/{id}', 'AdminController@viewLocation');
Route::get('/admin-view-order/{id}', 'AdminController@viewOrder');
Route::post('/update-order-courier', 'AdminController@updateCourier');

Route::get('/remove-courier/{id}', 'CourierController@remove');
Route::get('/edit-courier', 'CourierController@edit');
Route::post('/update-courier', 'CourierController@update');
Route::post('/save-courier', 'CourierController@save');

Route::get('/remove-software-user/{id}', 'SoftwareUserController@remove');
Route::get('/edit-software-user', 'SoftwareUserController@edit');
Route::post('/update-software-user', 'SoftwareUserController@update');
Route::post('/save-software-user', 'SoftwareUserController@save');

Route::get('/remove-location/{id}', 'LocationController@remove');
Route::get('/edit-location', 'LocationController@edit');
Route::post('/update-location', 'LocationController@update');
Route::post('/save-location', 'LocationController@save');

Route::post('/save-institute', 'InstituteController@save');
Route::get('/edit-institute', 'InstituteController@edit');
Route::post('/update-institute', 'InstituteController@update');
Route::get('/get-institute/{id}', 'InstituteController@getInstitute');
Route::get('/list-institutes/{page?}/{city?}/{country?}', 'InstituteController@listInstitutes');
Route::get('/remove-institute/{id}', 'InstituteController@remove');

Route::get('/logout', 'AuthenticationController@logout');

Route::get('/admin-get-cities/{state}', 'AdminController@getCities');