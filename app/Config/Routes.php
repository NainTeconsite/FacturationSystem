<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('dashboard', function ($routes) {
    
    $routes->get('product/trace/(:num)', '\App\Modules\Products\Controller\Products::trace/$1', ['as' => 'product.trace']);
    $routes->get('demopdf/(:num)', '\App\Modules\Products\Controller\Products::demoPDF/$1', ['as' => 'demopdf']);
    
    $routes->get('getUsers/(:alpha)', '\App\Modules\Users\Controller\Users::getUsers/$1');
    $routes->presenter('categories', ['namespace' => 'App\Modules\Categories\Controller']);
    $routes->presenter('tags', ['namespace' => 'App\Modules\Tags\Controller']);
    $routes->presenter('products', ['namespace' => 'App\Modules\Products\Controller']);
});

$routes->post('addStock', '\App\Modules\Products\Controller\Products::addStock');
$routes->post('removeStock', '\App\Modules\Products\Controller\Products::removeStock');