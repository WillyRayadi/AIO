<?php
$routes->get('sales/datas','Partner::sales_data');
$routes->get('sale/data/manage/(:num)', 'Partner::sales_data_manage/($1)');
$routes->get('deliveries/data', 'Partner::sales_warehouses_data');
$routes->get('deliveries/data/manage/(:num)', 'Partner::sales_warehouse_data_manage/$1');
$routes->get('partner/products/buys', "Partner::buys");