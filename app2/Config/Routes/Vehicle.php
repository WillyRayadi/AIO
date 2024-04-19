<?php
$routes->get('vehicles', 'Vehicle::vehicle');
$routes->post('vehicles/add', 'Vehicle::vehicle_add');
$routes->post('vehicles/edit', 'Vehicle::vehicle_edit');
$routes->get("vehicles/(:num)/delete", "Vehicle::vehicle_delete/$1");
