<?php
//kategori
$routes->get('products/categories', 'Product::products_categories');
$routes->post('products/categories/add', 'Product::products_categories_add');
$routes->post('products/categories/edit', 'Product::products_categories_edit');
$routes->get("products/categories/(:num)/delete", "Product::products_categories_delete/$1");

//produk
$routes->get('products', 'Product::products');
$routes->get("products/voucher", "Product::voucher");
$routes->get("products/ajaxGetSKU", "Product::ajaxGetSKU");
$routes->get("products/ajax/get/stocks", "Product::ajaxGetStocks");
$routes->get("products/get/products", "Product::ajaxGetProducts");
$routes->get("products/getProducts", "Product::getProducts");
$routes->get("products/capacity", "Product::kapasitas");
$routes->get("products/capacity/(:num)/delete", "Product::delete_capacity/$1");
$routes->get("products/voucher/(:num)/edit", "Product::edit_voucher/$1");
$routes->get("products/voucher/(:num)/delete", "Product::delete_voucher/$1");
$routes->post('products/add', 'Product::products_add');
$routes->post('products/edit', 'Product::products_edit');
$routes->post('products/stock', 'Product::products_stock');
$routes->get('products/(:num)/delete', 'Product::products_delete/$1');
$routes->post('products/search-filter-stock', 'Product::products_search_filter_stock');
$routes->post("products/ajaxGetCategories", "Product::ajaxGetCategories");
$routes->post("products/add/capacity", "Product::insert_capacity");
$routes->post('products/voucher/add', 'Product::add_voucher');
$routes->post('products/voucher/save', "Product::save_voucher");
$routes->get('products/get/sales/quantity', 'Product::getSalesQuantity');

// Routes untuk tampak depan 
$routes->post('upload/file/image', 'Product::upload_file_image');
$routes->get('delete/image/product/(:num)', 'Product::delete_image_product/$1');

// Routes untuk tampak belakang
$routes->post('upload/files/behind/images', 'Product::upload_files1_images');
$routes->get('delete/file/behind/products/(:num)', 'Product::delete_file_behind_product/$1');

// Routes untuk tampak kanan
$routes->post('upload/files/left/images', 'Product::upload_files2_images');
$routes->get('delete/file/left/products/(:num)', 'Product::delete_file_left_product/$1');

// Routes untuk tampak kiri
$routes->post('upload/files/right/images', 'Product::upload_files3_images');
$routes->get('delete/file/right/products/(:num)', 'Product::delete_file_right_product/$1');

$routes->get("products/get/indent/quantity", "Product::ajaxGetQuantityFromIndentWarehouse");
$routes->get("products/get/all/indent/quantity", "Product::ajaxGetAllIndentQuantity");
$routes->get("products/get/location/indent", "Product::ajaxGetIndentLocation");

$routes->get("products/export/all/qty", 'Product::export_quantitys');
$routes->get('products/test/page', 'Product::testPages');
