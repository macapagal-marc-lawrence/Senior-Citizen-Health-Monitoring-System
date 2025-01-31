<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Authentication route
 $routes->get('/login', 'Auth::login');
 $routes->get('/register', 'Auth::register');
 $routes->post('/doLogin', 'Auth::doLogin');
 $routes->post('/doRegister', 'Auth::doRegister');

$routes->get('/edit/(:num)', 'Admin::edit/$1');  // Edit user
$routes->post('/update/(:num)', 'Admin::update'); // Post edit user data
$routes->get('/delete/(:num)', 'Admin::delete/$1'); // Delete user
$routes->post('/admin/addUser', 'Admin::addUser'); //add user

// Admin dashboard route
$routes->get('/admin/adminDashboard', 'Admin::dashboard');
$routes->get('/admin/medicationHistory', 'Admin::medicationHistory');

// CareGiver dashboard route
$routes->get('/caregiver/caregiverDashboard', 'Caregiver::dashboard');
