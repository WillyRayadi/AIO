<?php

// $routes->get("api/point", "API\Point::index");
// $routes->get('api/point/myvoucher', 'API\Point::getMyVoucher');
// $routes->get('api/point/myredeemedvoucher', 'API\Point::getMyRedeemedVoucher');
// $routes->post("api/point/redeem", "API\Point::redeemPoint");

$routes->group('api', ['filter' => 'limiter'], function($routes) {
    $routes->get('point', "API\Point::index");
    $routes->get('point/myvoucher', 'API\Point::getMyVoucher');
    $routes->get('point/myredeemedvoucher', 'API\Point::getMyRedeemedVoucher');
    $routes->post('point/redeem', 'API\Point::redeemPoint');
    $routes->post('point/check/user/transaction', 'API\Point::checkUserTotalTransaction');
});