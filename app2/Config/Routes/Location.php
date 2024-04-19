<?php
$routes->get('locations', 'Location::locations'); 
$routes->post('locations/add', 'Location::locations_add');
$routes->post('locations/edit', 'Location::locations_edit');
$routes->get("locations/(:num)/delete", "Location::locations_delete/$1");