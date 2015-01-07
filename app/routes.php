<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('home', new Route('/', [
    '_controller' => 'Paracall\Controllers\HomeController::index',
]));

$routes->add('post', new Route('/post', array(
    '_controller' => 'Paracall\Controllers\PostController::index',
), array(), array(), '', array(), array('GET')));

$routes->add('post_process', new Route('/post', array(
    '_controller' => 'Paracall\Controllers\PostController::store',
), array(), array(), '', array(), array('POST')));

return $routes;
