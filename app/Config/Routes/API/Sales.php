<?php

// $routes->get('api/sales', 'API\Sales::index');

$routes->group('api', ['filter' => 'limiter'], function($routes) {
    $routes->get('sales', 'API\Sales::index'); 
});

?>