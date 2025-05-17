<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::index');
$routes->get('/register', 'AuthController::registerView');
$routes->post('auth/login', 'AuthController::login');
$routes->get('auth/logout', 'AuthController::logout');
$routes->post('form/register', 'AuthController::register');
$routes->get('home', 'AuthController::homeView');
$routes->get('index', 'Task::index');
$routes->get('archivadas', 'Task::archivadas');
$routes->post('task/create', 'Task::Create');
$routes->post('task/update/(:segment)', 'Task::update/$1');
$routes->post('task/delete/(:segment)', 'Task::delete/$1');
$routes->post('subtask/create', 'Subtask::create');
$routes->post('subtask/update/(:segment)', 'Subtask::update/$1');
$routes->post('subtask/delete/(:segment)', 'Subtask::delete/$1');
$routes->post('subtask/updateEstado', 'Subtask::updateEstado');

$routes->post('task/invite/(:segment)', 'Task::Invite/$1');
$routes->match(['get', 'post'], 'task/aceptar_invitacion/(:segment)', 'Task::aceptar_invitacion/$1');
$routes->match(['get', 'post'], 'task/rechazar_invitacion/(:segment)', 'Task::rechazar_invitacion/$1');
$routes->post('task/archivar/(:segment)', 'Task::archivar/$1');
$routes->post('auth/actualizarContrasenia', 'AuthController::actualizarContrasenia');