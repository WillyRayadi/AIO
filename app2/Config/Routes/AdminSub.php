<?php

$routes->post('add/submission/print', 'AdminSub::add_submission_print');

$routes->get('allowed/roles', 'AdminSub::data_allow_role');
$routes->get('report/allow/role', 'AdminSub::report_allow');
$routes->get('custom/insentif', 'AdminSub::custom_insentif');   
$routes->get('custom/insentif/manage/(:num)', 'AdminSub::custom_insentif_manage/$1');
$routes->post('set/custom/insentif', 'AdminSub::set_custom_insentif');
$routes->post('ajax/get/insentif', 'AdminSub::getInsentif');

$routes->get('export/user/stokaio', 'AdminSub::export_user');

$routes->post('add/customer/redeem', 'AdminSub::add_customer_redeeem');
$routes->get('redeem/points','AdminSub::redeem_point');
$routes->get('user/redeem/manage/(:num)', 'AdminSub::user_redeem_manage/$1');
$routes->post('add/product/redeem', 'AdminSub::add_product_redeem');

$routes->get('reports/contacts', 'AdminSub::report_contacts');
$routes->get('detail/export/data', 'Product::detail_export_products');

$routes->get('export/sale/tag', 'AdminSub::export_sale_tag');
$routes->get('report/sale/tag', 'AdminSub::report_sale_tag');

// user point membership
$routes->get('user/point', 'AdminSub::user_point');
$routes->get('redeem/manage/(:num)/user/(:num)', 'AdminSub::redeem_point_manage/$1/$2');
$routes->post('add/product/redeem', 'AdminSub::add_product_redeem');

$routes->get('report/item', 'AdminSub::report_ordered');

$routes->get('purchases','AdminSub::purchases');
$routes->get('purchases/manages/(:num)','AdminSub::purchases_manage/$1');
$routes->post('approve/purchases/product/(:num)','AdminSub::approve_purchase_order/$1');

$routes->get('report/histori/pengiriman', 'AdminSub::report_histori_pengiriman');
$routes->get('histori/pengiriman', 'AdminSub::histori_pengiriman');

$routes->get("return/pemasok", "AdminSub::return_pemasok");
$routes->post("return/pemasok/add","AdminSub::return_pemasok_add");
$routes->post("return/pemasok/add/items", "AdminSub::return_pemasok_add_items");
$routes->get("return/pemasok/manage/(:num)", "AdminSub::return_pemasok_manage/$1");
$routes->get('return/pemasok/print/(:num)','AdminSub::return_pemasok_print/$1');
$routes->get('return/pemasok/delete/(:num)', 'AdminSub::return_pemasok_delete/$1');
$routes->post('return/pemasok/insert_file', 'AdminSub::return_pemasok_insert_file');
$routes->get('return/pemasok/delete/(:num)/items/(:num)', 'AdminSub::return_pemasok_item_delete/$1/$2');

$routes->get('product/purchase/order','AdminSub::purchase_order');
$routes->post('purchase/order/add','AdminSub::purchase_order_add');
$routes->post('purchase/order/add/item', 'AdminSub::purchase_order_add_item');
$routes->get('purchase/order/manage/(:num)', 'AdminSub::purchase_order_manage/$1');
$routes->get('purchase/order/delete/(:num)', 'AdminSub::purchase_order_delete/$1');
$routes->get('purchase/order/export/(:num)', 'AdminSub::purchase_order_export/$1');
$routes->get('purchase/order/(:num)/delete/item/(:num)', 'AdminSub::purchase_order_items_delete/$1/$2');

$routes->post("ajax/check_ip","IP::ajax_check_ip");

$routes->get('products/(:num)/manage', 'AdminSub::products_manage/$1');
$routes->post('product/save/price', 'AdminSub::product_save_price');
$routes->post('product/save/margin', 'AdminSub::product_save_margin');

$routes->get("products/repairs","AdminXGudang::product_repairs");
$routes->post("products/repairs/add","AdminXGudang::product_repairs_add");
$routes->get("products/repairs/(:num)/delete","AdminXGudang::product_repairs_delete/$1");
$routes->post("product/repairs/ajax/edit","AdminXGudang::product_repairs_ajax_edit");
$routes->post("products/repairs/save","AdminXGudang::product_repairs_save");

$routes->get("products/returns","AdminXGudang::product_returns");
$routes->get("products/returns/manage/(:num)", "AdminXGudang::product_return_manage/$1");
$routes->post("products/returns/ajax/buy/items","AdminXGudang::product_returns_ajax_buy_items");
$routes->post("products/returns/ajax/buy/item/qty","AdminXGudang::product_returns_ajax_buy_item_qty");
$routes->post("products/returns/add","AdminXGudang::product_returns_add");
$routes->post("products/returns/save","AdminXGudang::product_returns_save");
$routes->get("products/returns/(:num)/delete","AdminXGudang::product_returns_delete/$1");
$routes->post("products/returns/ajax/edit","AdminXGudang::product_returns_ajax_edit");

$routes->get("products/stokOpname","AdminXGudang::product_displays");
$routes->post("products/stokOpname/add","AdminXGudang::product_displays_add");
$routes->get("products/stokOpname/(:num)/delete","AdminXGudang::product_displays_delete/$1");
$routes->post("product/stokOpname/ajax/edit","AdminXGudang::product_displays_ajax_edit");
$routes->post("products/stokOpname/save","AdminXGudang::product_displays_save");

$routes->get("products/stocks","AdminXGudang::product_stocks");
$routes->get("products/stocks/add","AdminXGudang::product_stocks_add");
$routes->post("products/buys/item/ajax", "AdminXGudang::products_buys_items_ajax");
$routes->post("products/stocks/add/ajax/qty_recorded","AdminXGudang::product_stocks_add_ajax_qty_recorded");
$routes->post("products/stocks/insert","AdminXGudang::product_stocks_insert");
$routes->get("products/stocks/(:num)/delete","AdminXGudang::product_stocks_delete/$1");

$routes->get("products/locations","AdminXGudang::product_locations");
$routes->get("products/available","AdminXGudang::products_available");
// $routes->get("product/(:num)/location/manage","AdminSub::product_location_manage/$1");
// $routes->post("product/location/save","AdminSub::product_location_save");

$routes->get("products/transfers", "AdminXGudang::products_transfers");
$routes->get('products/transfers/manage/(:num)', 'AdminXGudang::product_transfers_manage/$1');
$routes->get("products/transfers/add", "AdminXGudang::products_transfers_add");
$routes->post('products/transfers/items', 'AdminXGudang::products_transfers_items');
$routes->post("products/transfers/insert_data_awal", "AdminXGudang::products_transfers_insert_data_awal");
$routes->get("products/transfers/(:num)/delete", "AdminXGudang::product_transfers_delete/$1");
$routes->get('products/transfers/delete/(:num)/items/(:num)', 'AdminXGudang::product_transfers_delete_items/$1/$2');

$routes->get("promo/types","AdminSub::promo_types");
$routes->post("promo/types/add","AdminSub::promo_types_add");
$routes->post("promo/types/edit","AdminSub::promo_types_edit");
$routes->get("promo/types/(:num)/delete","AdminSub::promo_types_delete/$1");

$routes->get("promo","AdminSub::promo");
$routes->post("promo/add","AdminSub::promo_add");
$routes->get("promo/(:num)/delete","AdminSub::promo_delete/$1");
$routes->post("promo/ajax/edit","AdminSub::promo_ajax_edit");
$routes->post("promo/save","AdminSub::promo_save");

$routes->get("promo/(:num)/gifts","AdminSub::promo_gifts_manage/$1");
$routes->get("promo/(:num)/gifts/(:num)/delete","AdminSub::promo_gifts_delete/$1/$2");
$routes->post("promo/gifts/add","AdminSub::promo_gifts_add");

$routes->get("products/prices","AdminSub::product_prices");
$routes->post("products/prices/add","AdminSub::product_prices_add");
$routes->get("products/prices/(:num)/manage","AdminSub::product_prices_manage/$1");
$routes->post("products/prices/variables/add","AdminSub::product_prices_variables_add");
$routes->post("products/prices/formulas/add","AdminSub::product_prices_formulas_add");
$routes->post('products/prices/save',"AdminSub::product_prices_save");
$routes->post("products/prices/ajax/simulation","AdminSub::product_prices_ajax_simulation");

$routes->get("sales","AdminSub::sales");
$routes->get("sales/(:num)/manage","AdminSub::sales_manage/$1");
$routes->get("sales/(:num)/status/(:num)/set","AdminSub::sales_set_status/$1/$2");
$routes->get("sales/(:num)/invoice/print","AdminSub::sales_invoice_print/$1");
$routes->post("sales/manifest/print","AdminSub::sales_manifest_print/$1");
$routes->get("sales/(:num)/drive_letter/print","AdminSub::sales_drive_letter_print/$1");

// Routes For Ajax
$routes->get('ajax/sales', 'AdminSub::getSalesDataPerAllowedWarehouse');

// Routes untuk report data

$routes->get("reports_","AdminSub::reports_");
$routes->get("reports","AdminSub::reports");
$routes->get("reportss_","AdminSub::reportss_");
$routes->get('export_data', 'Product::exportData');
$routes->get("report_umurbarang","AdminSub::report_umurbarang");
$routes->get("reports/print","AdminSub::reports_print");
$routes->get("reports_so","AdminSub::reports_so");
$routes->get("report_userso","AdminSub::report_userso");
$routes->get("report_setuju","AdminSub::report_setuju");
$routes->get("report_kirim","AdminSub::report_kirim");
$routes->get("report_status", "AdminSub::report_status");
$routes->get("report_selesai","AdminSub::report_selesai");
$routes->get("report_barang_keluar","AdminSub::report_barang_keluar");
$routes->get("report_barang_masuk","AdminSub::report_barang_masuk");
$routes->get('report_penggunaan_harga','AdminSub::report_penggunaan_harga');
$routes->get("report_produk",'AdminSub::report_produk');
$routes->get("report/activity/customers", "AdminSub::report_activity_customer");
$routes->get('reports/report_activity_customer','AdminSub::data_activity_customer');
$routes->get('report_activity_approval','AdminSub::report_activity_approval');
$routes->get('report_produk_keluar','AdminSub::report_produk_keluar');
$routes->get('report_pergerakan_barang','AdminSub::report_pergerakan_barang');
$routes->get("reports/pergerakan_barang","AdminSub::report_pergerakan_barangs");
$routes->get("report_penjualan", "AdminSub::report_penjualan");
$routes->get("report_per_products", "AdminSub::report_per_products");
$routes->get("report_per_warehouse", "AdminSub::report_per_warehouse");
$routes->get("report/sales/bonus", "AdminSub::report_sales_bonus");
$routes->post("report/export/pergerakan_barang", "AdminSub::export_pergerakan_barang");
// end code routes report data

$routes->get('export/nominal/products', 'Product::export_nominal_product');

$routes->get("products/warehouse","AdminXGudang::products_warehouse");
$routes->post("AdminSub/ajax/sale/product/prices","AdminSub::ajax_sale_product_prices");

// Routes untuk role audit
$routes->get('products_transfers','Audit::products_transfers');
$routes->get('audit/transfers_manage/(:num)', 'Audit::products_transfers_manage/$1');
$routes->get('audit/sales','Audit::sales');
$routes->get('audit/sales/(:num)/manage','Audit::sales_manage/$1');
$routes->get('audit/warehouse_sales','Audit::sales_warehouse');
$routes->get('audit/product_all','Audit::product');
$routes->get('products_all/(:num)/manage', 'Audit::products_manage/$1');
$routes->get("audit/warehouse/sales/(:num)/manage","Audit::sales_manage_warehouse/$1/$2");
$routes->get('audit_product_buys', 'Audit::product_buys');
$routes->get('audit/product_buys_manage/(:num)','Audit::manage_product_buys/$1');
$routes->get('audit/report_sales','Audit::report_sales');
$routes->get('audit/report_produk','Audit::report_produk');

// Routes untuk pengiriman di role akun admin
$routes->get('sales_warehouse','AdminSub::sales_warehouse');
$routes->post("sales/driver/save","AdminSub::sales_drive_save");
$routes->post("sales/deliveries/save","AdminSub::deliveries_save");
$routes->post("sales/deliveries/add", "AdminSub::deliveries_add");
$routes->post("sales/deliveries/item/add", "AdminSub::deliveries_item_add");
$routes->get('sales/manage/(:num)/warehouse','AdminSub::sales_manage_warehouse/$1');
$routes->get("sales/sales/(:num)/deliveries/(:num)/delete","AdminSub::deliveries_delete/$1/$2");
$routes->get("sales/sales/(:num)/delivery_items/(:num)/delete","AdminSub::deliveries_items_delete/$1/$2");

$routes->get('sale/status/approve', 'AdminSub::status_approve');
$routes->get('sale/status/dikirim/sebagian', 'AdminSub::status_dikirim_sebagian');
$routes->get('sale/status/dikirim', 'AdminSub::status_dikirim');
$routes->get('sale/status/selesai', 'AdminSub::status_selesai');

// Routes untuk retur barang sales
$routes->post("products/returns/ajax/sale/items","AdminXGudang::product_returns_ajax_sale_items");
$routes->post("products/returns/ajax/sale/item/qty", "AdminXGudang::product_returns_ajax_sale_item_qty");

// Routes untuk data brands
$routes->get('brands','AdminSub::brands_index');
$routes->post('brand/add','AdminSub::brands_add');
$routes->get('brand/delete/(:num)', 'AdminSub::brands_delete/$1');

// Routes untuk data stok opname
$routes->get('stok_opname', 'AdminSub::stokOpname');
$routes->post('stokOpname/first/add', 'AdminSub::stokOpname_insert_first');
$routes->get('stok_opname/manage/(:num)', 'AdminSub::stokOpname_manage/$1');
$routes->post('stok/opname/item', 'AdminSub::stok_opname_item');
$routes->get('stok/opname/delete/(:num)', 'AdminSub::stok_opname_delete/$1');
$routes->get('stok/opname/item/(:num)/delete/(:num)', 'AdminSub::stok_opname_delete_item/$1/$2');
$routes->get('stok_opname/export/(:num)', 'AdminSub::export_stok_opname/$1');

$routes->get('sales/referral-code', 'AdminSub::referralCode');
$routes->post('sales/referral-code/add', 'AdminSub::addReferralCode');
$routes->get('ajax/get/all/sales', 'AdminSub::getAllSales');
?>