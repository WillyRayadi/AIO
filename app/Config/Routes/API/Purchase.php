<?php

$routes->group('api', ['filter' => 'authentication'], function($routes) {
    $routes->get('purchase/details', 'API/Purchases::index'); 
    $routes->post('purchase/insert', 'API/Purchases::insert');
    $routes->post('purchase/delete', 'API/Purchases::delete');
});