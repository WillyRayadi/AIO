<?php
$routes->get('codes', 'Code::codes');
$routes->post('codes/add', 'Code::codes_add');
$routes->post('codes/edit', 'Code::codes_edit');
$routes->get("codes/(:num)/delete", "Code::codes_delete/$1");
