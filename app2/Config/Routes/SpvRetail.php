<?php
$routes->get("/spv/retail/products","SpvRetail::products");
$routes->get("/spv/retail/products/(:num)/manage","SpvRetail::products_manage/$1");

$routes->get("/spv/retail/price/(:num)/product/(:num)/status/(:num)/set","SpvRetail::product_price_set/$1/$2/$3");

$routes->get("/spv/retail/price/approval","SpvRetail::price_approval");

$routes->get("spv/retail/sales","SpvRetail::sales");
$routes->get("spv/retail/sales/(:num)/manage","SpvRetail::sales_manage/$1");
?>