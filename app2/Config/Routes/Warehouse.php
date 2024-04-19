<?php
$routes->get('warehouses', 'Warehouse::warehouses');
$routes->post('warehouses/add', 'Warehouse::warehouses_add');
$routes->post('warehouses/edit', 'Warehouse::warehouses_edit');
$routes->get("warehouses/(:num)/delete", "Warehouse::warehouses_delete/$1");
