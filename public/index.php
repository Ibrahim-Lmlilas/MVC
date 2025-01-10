<?php
session_start();



require_once ('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/ClientController.php';
require_once '../app/controllers/FreelancerController.php';
require_once '../app/config/db.php';



$router = new Router();
Route::setRouter($router);



// Define routes
// auth routes 
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::post('/logout', [AuthController::class, 'logout']);

// admin routers
Route::get('/admin/dashboard', [AdminController::class, 'index']);
Route::get('/admin/users', [AdminController::class, 'handleUsers']);
Route::post('/admin/users/changeUserStatus', [AdminController::class, 'changeUserStatus']);
Route::post('/admin/users/removeUser', [AdminController::class, 'removeUser']);

Route::get('/admin/categories', [AdminController::class, 'categories']);
Route::post('/admin/categories/addModifyCategory', [AdminController::class, 'addModifyCategory']);
Route::post('/admin/categories/deleteCategory', [AdminController::class, 'deleteCategory']);
Route::post('/admin/categories/addModifySubCategory', [AdminController::class, 'addModifySubCategory']);
Route::post('/admin/categories/deleteSubCategory', [AdminController::class, 'deleteSubCategory']);


Route::get('/admin/testimonials', [AdminController::class, 'testimonials']);
Route::post('/admin/testimonials/removeTestimonial', [AdminController::class, 'removeTestimonial']);

Route::get('/admin/projects', [AdminController::class, 'Allprojects']);
Route::post('/admin/projects/removeProject', [AdminController::class, 'removeProject']);

// client routers
Route::get('/client/dashboard', [AdminController::class, 'index']);

Route::get('/client/projects', [ClientController::class, 'myprojects']);
Route::post('/client/projects/removeProject', [ClientController::class, 'removeProject']);
Route::post('/client/projects/addModifyProject', [ClientController::class, 'addModifyProject']);

Route::get('/client/offers', [ClientController::class, 'clientOffers']);
Route::post('/client/offers/acceptOffre', [ClientController::class, 'acceptOffre']);
Route::post('/client/offers/addModifyTestimonial', [ClientController::class, 'addModifyTestimonial']);

Route::get('/client/testimonials', [ClientController::class, 'testimonials']);
Route::post('/client/testimonials/removeTestimonial', [ClientController::class, 'removeTestimonial']);


// freelancer routers
Route::get('/freelancer/dashboard', [AdminController::class, 'index']);
Route::get('/freelancer/projects', [FreelancerController::class, 'Allprojects']);

Route::post('/freelancer/projects/submitOffer', [FreelancerController::class, 'addModifyOffer']);
Route::get('/freelancer/offers', [FreelancerController::class, 'freelancerOffers']);
Route::post('/freelancer/deleteOffer', [FreelancerController::class, 'deleteOffer']);

Route::get('/freelancer/testimonials', [FreelancerController::class, 'testimonials']);



// end admin routes 

// client Routes 
// Route::get('/client/dashboard', [ClientController::class, 'index']);



// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);



