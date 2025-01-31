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

// Admin dashboard route
$routes->get('/admin/adminDashboard', 'Admin::dashboard');
