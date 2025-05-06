<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::index');
$routes->get('/register', 'AuthController::registerView');
$routes->post('auth/login', 'AuthController::login');
$routes->post('form/register', 'AuthController::register');
$routes->get('home', 'AuthController::homeView');

