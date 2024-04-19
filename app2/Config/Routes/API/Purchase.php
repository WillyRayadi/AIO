<?php

// $routes->get('index','API/Purchase::index');
$routes->get('purchases/items/(:num)/delete', 'API/Purchase::purchases_delete/$1');
$routes->post('add/purchases/order/(:num)', 'API/Purchase::add_purchases_order/$1');

$routes->get('purchase/manage/(:num)', 'API/PurchaseItem::index');

$routes->group('api', ['filter' => 'authentication'], function($routes) {
        $routes->get('purchases/details', 'API/Purchases::index'); 
});