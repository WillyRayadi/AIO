<?php
$routes->get('customers', 'Customer::customers');
$routes->post('customers/add', 'Customer::customers_add');
$routes->post('customers/edit', 'Customer::customers_edit');
$routes->get("customers/(:num)/delete", "Customer::customers_delete/$1");
