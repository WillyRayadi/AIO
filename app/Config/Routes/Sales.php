<?php
// Testing
$routes->get("sale/test/page", "Sales::testPage");
$routes->get("ajax/get/sales", "Sales::getSales");
// 
$routes->get("sales/sales","Sales::sales");
$routes->get("sales/sales/grosir","Sales::sales_grosir");
$routes->get("sales/sales/add","Sales::sales_add");
$routes->post("sales/ajax/sales/add/contact/data","Sales::ajax_sales_add_contact_data");
$routes->post("sales/ajax/sales/add/expired/data","Sales::ajax_sales_add_expired_data");
$routes->post("sales/sales/insert","Sales::sales_insert");
$routes->get("sales/sales/(:num)/manage","Sales::sales_manage/$1");
$routes->get("sales/sales/grosir/(:num)/manage","Sales::sales_grosir_manage/$1");
$routes->get("sales/sales/(:num)/delete","Sales::sales_delete/$1");
$routes->get("sales/sales/(:num)/item/(:num)/delete","Sales::sales_item_delete/$1/$2");
$routes->get("sale/sales/(:num)/item/(:num)/deletes","Sales::sales_item_deletes/$1/$2");
$routes->post("sales/item/edit/qty","Sales::sales_item_edit_qty");

$routes->post("sales/ajax/test/sale/product/all","Sales::ajax_test_sale_product_all");

$routes->post("sales/ajax/sale/product/all","Sales::ajax_sale_product_all");
$routes->post("sales/ajax/sale/product/stocks","Sales::ajax_sale_product_stocks");
$routes->post("sales/ajax/sale/product/prices","Sales::ajax_sale_product_prices");
$routes->post("sales/ajax/sale/product/promos","Sales::ajax_sale_product_promos");
$routes->post("sales/ajax/sale/products/stocks/ass","Sales::ajax_sale_products_stocks_ass");
$routes->post("sales/ajax/sale/products/stocks/display","Sales::ajax_sale_products_stocks_display");
$routes->post("sales/ajax/get/user", "Sales::ajaxGetUser");
$routes->post("sales/export_per_products", "Sales::export_per_products");

$routes->post("sales/sale/item/add","Sales::sale_item_add");
$routes->post("sales/sales/save","Sales::sales_save");
//Testing
$routes->post("sales/test/sales/save","Sales::test_sales_save");

$routes->post("sales/contacts/add/direct_sales_add","Sales::contacts_add_direct_sales_add");
$routes->post("sales/contacts/add/direct_sales_manage","Sales::contacts_add_direct_sales_manage");

$routes->get('sales/transfers/manage/(:num)', 'Sales::product_transfers_manage/$1');
$routes->get("sales/transfers", "Sales::products_transfers");
$routes->post("sales/transfers/insert_data_awal", "Sales::products_transfers_insert_data_awal");
$routes->get('sales/transfers/delete/(:num)/items/(:num)', 'Sales::product_transfers_delete_items/$1/$2');
$routes->get("sales/transfers/add", "Sales::products_transfers_add");
$routes->post('sales/transfers/edit','Sales::product_transfers_edit');
$routes->post('sales/transfers/items', 'Sales::products_transfers_items');

$routes->post('sales/comment/add', 'Sales::sales_comment_add');
$routes->get('sales/perubahan/status', 'Sales::sales_perubahan_status');

$routes->get("sales/delivery/(:num)/manage",'Sales::delivery_order_manage/$1');

$routes->get('sales/status/approve','Sales::status_approve');
$routes->get('sales/status/dikirim/sebagian','Sales::status_dikirim_sebagian');
$routes->get('sales/status/dikirim','Sales::status_dikirim');
$routes->get('sales/status/selesai','Sales::status_selesai');

// Routes untuk fitur retur barang sales
$routes->get('sales/sale/retur','Sales::sales_return');
$routes->post("sales/return/add","Sales::sales_return_add");
$routes->get('sales/sale/retur/delete/(:num)', 'Sales::sales_return_delete/$1');
$routes->get('sales/sale/retur/manage/(:num)',"Sales::sales_return_manage/$1");
$routes->post('sales/return/add/items','Sales::sales_return_add_items');
$routes->get('sales/sale/retur/print/(:num)', 'Sales::sales_retur_print/$1/$2');
$routes->get('sales/sale/retur/delete/(:num)/items/(:num)', 'Sales::sales_return_delete_items/$1/$2');

// Routes untuk fitur status pengiriman
$routes->get('warehouses/sales/(:num)/manage', 'Sales::sales_manage_warehouse/$1');
?>