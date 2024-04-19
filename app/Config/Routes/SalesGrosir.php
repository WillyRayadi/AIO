<?php
$routes->get("sales/grosir/sales","SalesGrosir::sales");
$routes->get("sales/grosir/sales/add","SalesGrosir::sales_add");
$routes->post("sales/grosir/ajax/sales/add/contact/data","SalesGrosir::ajax_sales_add_contact_data");
$routes->post("sales/grosir/ajax/sales/add/expired/data","SalesGrosir::ajax_sales_add_expired_data");
$routes->post("sales/grosir/sales/insert","SalesGrosir::sales_insert");
$routes->get("sales/grosir/sales/(:num)/manage","SalesGrosir::sales_manage/$1");
$routes->get("sales/grosir/sales/(:num)/delete","SalesGrosir::sales_delete/$1");
$routes->get("sales/grosir/sales/(:num)/item/(:num)/delete","SalesGrosir::sales_item_delete/$1/$2");

$routes->post("sales/grosir/ajax/sale/product/stocks","SalesGrosir::ajax_sale_product_stocks");
$routes->post("sales/grosir/ajax/sale/product/prices","SalesGrosir::ajax_sale_product_prices");
$routes->post("sales/grosir/ajax/sale/product/promos","SalesGrosir::ajax_sale_product_promos");

$routes->post("sales/grosir/sale/item/add","SalesGrosir::sale_item_add");
$routes->post("sales/grosir/sales/save","SalesGrosir::sales_save");
?>