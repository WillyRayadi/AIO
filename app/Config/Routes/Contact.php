<?php
$routes->get('contacts', 'Contact::contact');
$routes->post('contacts/add', 'Contact::contact_add');
$routes->post('contacts/add/direct_buy_add', 'Contact::contact_add_direct_buy_add');
$routes->post('contacts/add/direct_buy_manage', 'Contact::contact_add_direct_buy_manage');
$routes->post('contacts/edit', 'Contact::contact_edit');
$routes->get("contacts/(:num)/delete", "Contact::contact_delete/$1");
$routes->get("export/contact_customers", 'Contact::export_contacts_customer');
$routes->get("export/contact_supplier", 'Contact::export_contacts_supplier');