<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('login', 'Auth::login', ['as' => 'login-user-view']);
$routes->post('login', 'Auth::processLogin',['as' => 'processUserLogin']);

$routes->get('register', 'Auth::register', ['as' => 'register']);
$routes->post('register', 'Auth::processRegister', ['as' => 'processRegister']);


$routes->get('dashboard', 'Dashboard::index',['as' => 'dashboard']);
$routes->get('user-url', 'UserUrl::index',['as'=>'user-url-screen']);
$routes->post('create-dynamic-url', 'UserUrl::createDynamicUrl', ['as' => 'create-dynamic-url']);


$routes->put('edit-dynamic-url/(:segment)', 'UserUrl::editDynamicUrl/$1', ['as' => 'edit-dynamic-url']);
$routes->delete('delete-dynamic-url/(:segment)', 'UserUrl::deleteDynamicUrl/$1', ['as' => 'delete-dynamic-url']);

$routes->get('world/link/(:segment)', 'DynamicController::showDynamic/$1', ['as' => 'dynamic-link']);
