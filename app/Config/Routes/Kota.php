<?php
$routes->get('branch', 'Branch::branch'); 
$routes->post('branch/add', 'Branch::branch_add');
$routes->post('branch/edit', 'Branch::branch_edit');
$routes->get("branch/(:num)/delete", "Branch::branch_delete/$1");