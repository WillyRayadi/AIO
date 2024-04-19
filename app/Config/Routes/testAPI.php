<?php

$routes->get("voucher/get/list", "testAPI::getListVoucher");
$routes->get("voucher/get/point", "testAPI::getContact");
$routes->get("voucher/get/products", "testAPI::getVoucherByCategory");
$routes->get("user/get/point", "testAPI::getUserPoint");
$routes->get('voucher/get/all', 'testAPI::getAllVoucher');
$routes->get('user/get/redeemed/voucher', 'testAPI::getUserVoucher');
$routes->get('user/get/total/transaction', 'testAPI::getTotalUserTransaction');

$routes->post("user/add", "testAPI::addUser");
$routes->post("user/check", "testAPI::checkUser");
$routes->post("user/insert", "testAPI::insertContact");
$routes->post("check/user", "testAPI::isUserExist");
$routes->post("user/update", "testAPI::updateUsers");
$routes->post("user/insert/new/address", "testAPI::insertNewAddress");
$routes->post("points/(:num)/exchange", "testAPI::exchange_voucher/$1");
$routes->post('user/point/exchange', 'testAPI::exchangeUserPoint');
$routes->post('user/update/primary/address', 'testAPI::updateUserPrimaryAddress');
$routes->post('user/delete/address', 'testAPI::deleteUserAddress');
$routes->post('user/update/address', "testAPI::updateAddress");

// $routes->group('user', ['filter' => 'limiter'], function($routes) {
//     $routes->get('get/point', 'testAPI::getUserPoint');
//     $routes->get('get/redeemed/voucher', 'testAPI::getUserVoucher');
//     $routes->get('get/total/transaction', 'testAPI::getTotalUserTransaction');
//     $routes->post('add', 'testAPI::addUser');
//     $routes->post('check', 'testAPI::checkUser');
//     $routes->post('insert', 'testAPI::insertContact');
//     $routes->post('update', 'testAPI::updateUsers');
//     $routes->post('insert/new/address', 'testAPI::insertNewAddress');
// });