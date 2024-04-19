<?php
$routes->get("sales/retail/sales","SalesRetail::sales");
$routes->get("sales/retail/sales/add","SalesRetail::sales_add");
$routes->post("sales/retail/sales/insert","SalesRetail::sales_insert");
$routes->get("sales/retail/sales/(:num)/manage","SalesRetail::sales_manage/$1");
$routes->get("sales/retail/sales/(:num)/item/(:num)/delete","SalesRetail::sales_item_delete/$1/$2");

$routes->post("sales/retail/ajax/sale/product/stocks","SalesRetail::ajax_sale_product_stocks");
$routes->post("sales/retail/ajax/sale/product/prices","SalesRetail::ajax_sale_product_prices");

$routes->post("sales/retail/sale/item/add","SalesRetail::sale_item_add");
$routes->post("sales/retail/sales/save","SalesRetail::sales_save");
?>