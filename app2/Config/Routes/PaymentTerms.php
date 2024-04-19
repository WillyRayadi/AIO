<?php
$routes->get('payment/terms', 'PaymentTerms::buy_terms_manage');
$routes->get('payment/terms/delete/(:num)', 'PaymentTerms::buy_terms_delete/$1');
$routes->post('payment/terms/add', 'PaymentTerms::buy_terms_add');
$routes->post('payment/terms/edit', 'PaymentTerms::buy_terms_update');
