<?php
// $routes->post('api/user/insert/contact', 'API\Contacts::insertContacts');

$routes->group('api', ['filter' => 'limiter'], function($routes) {
    $routes->post('user/insert/contact', 'API\Contacts::insertContacts'); 
});

?>