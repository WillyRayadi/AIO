<?php
$routes->get('Sale', 'SalesAPI::index');
$routes->get('Sale/show/(:num)', 'SalesAPI::show/$1');
$routes->get('Sale/print/invoices/(:num)', 'SalesAPI::export_invoice/$1');
?>