<?php
$routes->get('accounting/products/buys', 'Accounting::product_buys');
$routes->get('accounting/sales', 'Accounting::sales');
//$routes->post('admin/comment/add', 'Buys::admin_comment_add');
$routes->get('accounting/product/buys/(:num)/manage', 'Accounting::manage_product_buys/$1');
$routes->get('ajax/accounting/sales', 'Accounting::getSalesDataPerAllowedWarehouse');
$routes->get('accounting/sales(:num)/manage', 'Accounting::sales_manage/$1');

// $routes->post('products/buy/add', 'Buys::product_buys_add_admin');
// $routes->post('products/buys/add', 'Buys::product_buys_add');

// $routes->post('products/buys/edit', 'Buys::product_buys_edit');
// $routes->get('perubahan/data', 'Buys::perubahan_data');
// $routes->get('perubahan/data/manage/(:num)','Buys::perubahan_data_manage/$1');
// $routes->get('perubahan/data/manages/(:num)','Buys::perubahan_data_manages/$1');

// // Upload Surat Jalan Pembelian 
// $routes->post("purchase/shipping/receipts","Buys::purchase_shipping_receipt");
// $routes->get("purchase/(:num)/delete/shipping_receipt","Buys::purchase_delete_shipping_receipt/$1");

// $routes->post("/process_login", "Login::process_login");
