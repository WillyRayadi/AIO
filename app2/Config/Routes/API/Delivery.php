<?php

$routes->group('api', ['filter' => 'authentication'], function($routes) {
    $routes->post('delivery/details', 'API\Delivery::index');
    $routes->post('delivery/save', 'API\Delivery::insert');
    $routes->post('delivery/delete', "API\Delivery::delete");
});

?>