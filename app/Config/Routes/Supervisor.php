<?php

$routes->get("custom/insentif/supervisor", "Supervisor::custom_insentif");
$routes->get("custom/insentif/manage/(:num)/supervisor", "Supervisor::custom_insentif_manage/$1");
$routes->get("supervisor/sales", "Supervisor::sales");
$routes->get("supervisor/my/sales", "Supervisor::mySales");
$routes->get("supervisor/sales/add", "Supervisor::sales_add");
$routes->get("supervisor/sales/(:num)/manage", "Supervisor::sales_manage/$1");
$routes->get("supervisor/penjualan/(:num)/manage", "Supervisor::sales_supervisor_manage/$1");
$routes->get("supervisor/sales/(:num)/delete", "Supervisor::sales_delete/$1");
$routes->get("supervisor/penjualan/(:num)/delete", "Supervisor::sales_delete_penjualan/$1");
$routes->get("supervisor/sales/(:num)/item/(:num)/delete", "Supervisor::sales_item_delete/$1/$2");

$routes->get("supervisor/sales/need_approval", "Supervisor::sales_need_approval");
$routes->get("supervisor/sales/(:num)/item/(:num)/approve", "Supervisor::sales_item_approve/$1/$2");
$routes->get("supervisor/sales/(:num)/item/(:num)/unapprove", "Supervisor::sales_item_unapprove/$1/$2");

$routes->get("supervisor/target", "Supervisor::target");
$routes->post("supervisor/target/save", "Supervisor::target_save");
$routes->post("supervisor/sales/save", "Supervisor::sales_save");
$routes->post("supervisor/sale/item/add", "Supervisor::sale_item_add");

$routes->get("supervisor/products", "Supervisor::products");

$routes->post("supervisor/ajax/sale/product/all", "Supervisor::ajax_sale_product_all");
$routes->post("supervisor/ajax/sale/product/stocks", "Supervisor::ajax_sale_product_stocks");
$routes->post("supervisor/ajax/sale/product/prices", "Supervisor::ajax_sale_product_prices");
$routes->post("supervisor/ajax/sale/product/promos", "Supervisor::ajax_sale_product_promos");
$routes->post("supervisor/ajax/sales/add/contact/data", "Supervisor::ajax_sales_add_contact_data");
$routes->post("supervisor/ajax/sales/add/expired/data", "Supervisor::ajax_sales_add_expired_data");
