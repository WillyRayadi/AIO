<?php

$routes->group('api', ['filter' => 'limiter'], function($routes) {
    $routes->get('products', 'API\Products::index');
    $routes->get('data/products', 'API\Products::dataProduct');
    $routes->get('products/show', 'API\Products::getFilteredProducts');
    $routes->get('products/show/per/categories', 'API\Products::getProductsByCategories');
    $routes->get('products/get/total/products', 'API\Products::getTotalProducts');
});