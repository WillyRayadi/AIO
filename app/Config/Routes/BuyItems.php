<?php
$routes->get('products/buys/manage/(:num)', 'BuyItems::manage_product_buys/$1');
$routes->get('products/buy/manage/(:num)', 'BuyItems::manage_product_buy_admin/$1');
$routes->get('products/purchase/delete/(:num)/(:num)', 'BuyItems::products_purchase_delete/$1/$2');
$routes->get('products/purchase/deletes/(:num)/(:num)', 'BuyItems::products_purchase_delete_admin/$1/$2');
$routes->post('product/purchase/add', 'BuyItems::products_purchase_add_admin');
$routes->post('products/purchase/add', 'BuyItems::products_purchase_add');
$routes->post('products/purchase/edit', 'BuyItems::products_purchase_update');
