<?php
$routes->get('suppliers', 'Supplier::suppliers');
$routes->post('suppliers/add', 'Supplier::suppliers_add');
$routes->post('suppliers/edit', 'Supplier::suppliers_edit');
$routes->get("suppliers/(:num)/delete", "Supplier::suppliers_delete/$1");
