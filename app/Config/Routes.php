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
$routes->get('index', 'Task::index');
$routes->post('task/create', 'Task::Create');
$routes->post('task/update/(:segment)', 'Task::update/$1');
$routes->post('task/delete/(:segment)', 'Task::delete/$1');


