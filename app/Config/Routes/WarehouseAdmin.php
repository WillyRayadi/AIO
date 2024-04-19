<?php
$routes->get("warehouse/sales","WarehouseAdmin::sales_warehouse");
$routes->get("warehouse/sales/(:num)/manage","WarehouseAdmin::sales_manage_warehouse/$1");
$routes->get("warehouse/sales/(:num)/status/(:num)/set","WarehouseAdmin::sales_set_status/$1/$2");
$routes->get("warehouse/sales/(:num)/drive_letter/print","WarehouseAdmin::sales_drive_letter_print_warehouse/$1");
$routes->post("warehouse/sales/drive/save","WarehouseAdmin::sales_drive_save");

$routes->post("warehouse/sales/upload/shipping_receipt","WarehouseAdmin::sales_upload_shipping_receipt");
$routes->get("warehouse/sales/(:num)/delete/(:num)/shipping_receipt","WarehouseAdmin::sales_delete_shipping_receipt/$1/$2");

// $routes->get("sales","WarehouseAdmin::sales");
// $routes->get("sales/(:num)/manage","WarehouseAdmin::sales_manage/$1");
// $routes->get("sales/(:num)/status/(:num)/set","WarehouseAdmin::sales_set_status/$1/$2");
// $routes->get("sales/(:num)/invoice/print","WarehouseAdmin::sales_invoice_print/$1");
// $routes->get("sales/(:num)/drive_letter/print","WarehouseAdmin::sales_drive_letter_print/$1");

$routes->post("warehouse/deliveries/add","WarehouseAdmin::deliveries_add");
$routes->post("warehouse/deliveries/save","WarehouseAdmin::deliveries_save");
$routes->get("warehouse/sales/(:num)/deliveries/(:num)/print","AdminSub::deliveries_print/$1/$2");
$routes->get("warehouse/sales/(:num)/deliveries/(:num)/delete","WarehouseAdmin::deliveries_delete/$1/$2");
$routes->post("warehouse/deliveries/item/add","WarehouseAdmin::deliveries_item_add");
$routes->post("warehouse/deliveries/item/save","WarehouseAdmin::deliveries_item_save");
$routes->get("warehouse/sales/(:num)/delivery_items/(:num)/delete","WarehouseAdmin::deliveries_items_delete/$1/$2");

$routes->get('warehouse/delivery_orders','WarehouseAdmin::delivery_orders');

$routes->get('products/transfers/(:num)/print/(:num)','AdminSub::transfers_print/$1/$2');

$routes->get('sale/status/approve', 'WarehouseAdmin::status_approve');
$routes->get('sale/status/dikirim/sebagian', 'WarehouseAdmin::status_dikirim_sebagian');
$routes->get('sale/status/dikirim', 'WarehouseAdmin::status_dikirim');
$routes->get('sale/status/selesai', 'WarehouseAdmin::status_selesai');
?>