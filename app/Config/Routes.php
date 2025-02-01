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
$routes->get('/admin/approveUser/(:num)', 'Admin::approveUser/$1'); // approving user
$routes->get('/admin/rejectUser/(:num)', 'Admin::rejectUser/$1'); //rejecting user

//Assigning, changing, saving caregiver
$routes->get('/admin/assignCaregiver/(:num)', 'Admin::assignCaregiver/$1');
$routes->get('/admin/changeCaregiver/(:num)', 'Admin::changeCaregiver/$1');
$routes->post('/admin/saveCaregiverChange/(:num)', 'Admin::saveCaregiverChange/$1');

// Admin dashboard route
$routes->get('/admin/adminDashboard', 'Admin::dashboard');
$routes->get('/admin/medicationHistory', 'Admin::medicationHistory');
$routes->get('/admin/medicationReports', 'Admin::medicationReports');
$routes->get('/admin/healthReports', 'Admin::healthReports');
$routes->get('/admin/healthHistory', 'Admin::healthHistory');

// CareGiver dashboard route
$routes->get('/caregiver/caregiverDashboard', 'Caregiver::dashboard');
// View Health Records for a specific senior citizen
$routes->get('/caregiver/viewHealthRecords/(:num)', 'Caregiver::viewHealthRecords/$1');
// Add Health Record for a specific senior citizen
$routes->post('/caregiver/addHealthRecord/(:num)', 'Caregiver::addHealthRecord/$1');
// Add Health Record for a specific senior citizen
$routes->post('/caregiver/addReminder/(:num)', 'Caregiver::addReminder/$1');
// Add Medication Record for a specific senior citizen
$routes->post('/caregiver/addMedication/(:num)', 'Caregiver::addMedication/$1');

// Senior dashboard route
$routes->get('/senior/seniorDashboard', 'Senior::dashboard');

