<?php 
    // $routes->get('voucher/products', 'API\voucherAPI::index');
    // $routes->get('voucher/products/category', 'API\voucherAPI::getByCategory');
    
    $routes->group('voucher', ['filter' => 'limiter'], function($routes) {
        $routes->get('products', 'API\voucherAPI::index');
        $routes->get('products/category', 'API\voucherAPI::getByCategory');
    });
?>