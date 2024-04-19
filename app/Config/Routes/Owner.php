<?php
// $routes->get("owner/products","Owner::products");
// $routes->get("owner/products/(:num)/manage","Owner::products_manage/$1");

// $routes->get("owner/price/(:num)/product/(:num)/status/(:num)/set","Owner::product_price_set/$1/$2/$3");
// $routes->get("owner/price/approval","Owner::price_approval");

$routes->get("approve/submission/do", "Owner::approve_do");
$routes->get("approve/do/manage/(:num)", "Owner::approve_do_manage/$1");
$routes->get("approve/do/check/(:num)","Owner::approve_do_check/$1");

$routes->get("owner/products/locations","Owner::products_locations");

$routes->get("owner/sales","Owner::sales");
$routes->get("owner/sales/(:num)/manage","Owner::sales_manage/$1");

$routes->get("owner/sales/need_approval","Owner::sales_need_approval");
$routes->get("owner/sales/(:num)/item/(:num)/approve","Owner::sales_item_approve/$1/$2");
$routes->get("owner/sales/(:num)/item/(:num)/unapprove","Owner::sales_item_unapprove/$1/$2");

$routes->get("owner/target","Owner::target");
$routes->post("owner/target/save","Owner::target_save");

$routes->get("owner/addresses","Owner::addresses");
$routes->post("owner/addresses/add","Owner::addresses_add");
$routes->get("owner/addresses/(:num)/delete","Owner::addresses_delete/$1");
$routes->post("owner/addresses/save","Owner::addresses_save");

$routes->get("owner/perubahan/status","Owner::perubahan_status/$1");
$routes->get("owner/perubahan/status/manage/(:num)","Owner::perubahan_status_manage/$1");
$routes->get("owner/approve/(:num)/perubahan","Owner::approve_perubahan/$1");
$routes->get("owner/unapprove/(:num)/perubahan","Owner::unapprove_perubahan/$1");

$routes->get("owner/insentif", "Owner::insentif_karyawan");
$routes->get("owner/insentif/", "Owner::insentif_karyawan");
$routes->get("owner/insentif/(:num)/manage", "Owner::insentif_manage/$1");
$routes->get("owner/insentif/(:num)/delete", "Owner::insentif_delete/$1");
$routes->post("owner/insentif/add", "Owner::insentif_add");
$routes->post("owner/insentif/save", "Owner::insentif_save");

$routes->get("owner/perubahan/data","Owner::perubahan_data/$1");
$routes->get("owner/perubahan/data/manage/(:num)", "Owner::perubahan_data_manage/$1");
$routes->get("owner/approve/(:num)/perubahan_data/(:num)","Owner::approve_perubahan_data/$1/$2");

?>