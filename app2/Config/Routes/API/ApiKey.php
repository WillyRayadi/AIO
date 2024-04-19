<?php

// $routes->post('api/generate-key', 'API\ApiKey::insert');
// $routes->post('api/check-key', 'API\ApiKey::checkApiKey');

$routes->group('api', ['filter' => 'authentication'], function($routes) {
    $routes->post('check-key', 'API\ApiKey::checkApiKey');
    $routes->post('generate-key', 'API\ApiKey::insert');
});

?>