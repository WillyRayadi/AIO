<?php
$routes->get('account', 'Account::account');
$routes->get('account/view_add_account', 'Account::view_add_account');
$routes->post('account/add', 'Account::account_add');
$routes->get('account/view_edit_account/(:num)', 'Account::view_edit_account/$1');
$routes->post('account/edit', 'Account::account_edit');
$routes->get('management/account','Account::management_role_account');
$routes->post('role/fitur/add/(:num)', 'Account::role_fitur_add/$1');
$routes->get('role/manage/account/(:num)', 'Account::role_account_manage/$1');
$routes->post("account/reset_password", "Account::account_reset_password");