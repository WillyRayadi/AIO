<?php
$routes->get('products','Cashier::products');
$routes->get('cashier/data/contacts','Cashier::contacts');
$routes->get('cashier/user/redeems', 'Cashier::user_redeems');
$routes->get('cashier/user/redeem/manage/(:num)', 'Cashier::redeem_item_manage/$1');
$routes->post('add/member/redeem', 'Cashier::add_member_redeem');
$routes->get('cashier/user/point', 'Cashier::user_point');