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
$routes->post('dashboard/updateStatus', 'Dashboard::updateStatus', ['as' => 'updateStatus']);
$routes->get('dashboard/getButtonStatus', 'Dashboard::getButtonStatus', ['as' => 'fetchStatus']);

$routes->get('user-url', 'UserUrl::index',['as'=>'user-url-screen']);
$routes->post('create-dynamic-url', 'UserUrl::createDynamicUrl', ['as' => 'create-dynamic-url']);


$routes->post('edit-dynamic-url', 'UserUrl::editDynamicUrl', ['as' => 'edit-dynamic-url']);
$routes->post('delete-dynamic-url', 'UserUrl::deleteDynamicUrl', ['as' => 'delete-dynamic-url']);

$routes->get('world/link/(:segment)', 'DynamicController::showDynamic/$1', ['as' => 'dynamic-link']);
