<?php
$routes->get("/spv/grosir/products","SpvGrosir::products");
$routes->get("/spv/grosir/products/(:num)/manage","SpvGrosir::products_manage/$1");

$routes->get("/spv/grosir/price/(:num)/product/(:num)/status/(:num)/set","SpvGrosir::product_price_set/$1/$2/$3");

$routes->get("/spv/grosir/price/approval","SpvGrosir::price_approval");

$routes->get("spv/grosir/sales","SpvGrosir::sales");
$routes->get("spv/grosir/sales/(:num)/manage","SpvGrosir::sales_manage/$1");
?>