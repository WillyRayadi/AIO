<?php
$routes->get('tags', 'Tags::tags');
$routes->post('tags/add', 'Tags::tags_add');
$routes->post('tags/edit', 'Tags::tags_edit');
$routes->get("tags/(:num)/delete", "Tags::tags_delete/$1");
