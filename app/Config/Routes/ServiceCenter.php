<?php
    $routes->get('returns/data', 'ServiceCenter::return_pemasok');
    $routes->get('returns/manage/(:num)', 'ServiceCenter::return_pemasok_manage/$1');  
    $routes->post('returns/pemasok/add', 'ServiceCenter::return_pemasok_add');
    $routes->post('returns/pemasok/add/items', 'ServiceCenter::return_pemasok_add_items');
    $routes->get('returns/pemasok/print/(:num)','ServiceCenter::return_pemasok_print/$1');
    $routes->get('returns/pemasok/delete/(:num)', 'ServiceCenter::return_pemasok_delete/$1');
    $routes->get('returns/pemasok/delete/(:num)/item/(:num)', 'ServiceCenter::return_pemasok_item_delete/$1/$2');
    $routes->post('returns/pemasok/insert_file', 'ServiceCenter::return_pemasok_insert_file');
    
    $routes->get("warehouse/transfers","ServiceCenter::warehouse_transfers");
    $routes->get('warehouse/transfers/manage/(:num)','ServiceCenter::warehouse_transfers_manage/$1');
    $routes->get("warehouse/transfers/add","ServiceCenter::add_warehouse_transfers_header");
    $routes->post('warehouse/transfers/items','ServiceCenter::warehouse_transfers_items');
    $routes->post("warehouse/transfers/insert_data_awal","ServiceCenter::add_warehouse_transfers_header");
    $routes->get("warehouse/transfers/(:num)/delete","ServiceCenter::warehouse_transfers_delete/$1");
    $routes->get('warehouse/transfers/delete/(:num)/items/(:num)','ServiceCenter::warehouse_transfers_delete_items/$1/$2');