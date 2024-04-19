<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
require "Routes/Login.php";
require "Routes/Logout.php";
require "Routes/Dashboard.php";
require "Routes/Buys.php";
require "Routes/BuyItems.php";
require "Routes/PaymentTerms.php";
require "Routes/Tags.php";
require "Routes/Contact.php";
require "Routes/Vehicle.php";
require "Routes/Kota.php";
require "Routes/Accounting.php";




require "Routes/Supplier.php";
require "Routes/Product.php";
require "Routes/Account.php";
require "Routes/Code.php";
require "Routes/Location.php";
require "Routes/Customer.php";
require "Routes/Warehouse.php";

require "Routes/Cashier.php";
require "Routes/AdminSub.php";

require "Routes/Supervisor.php";
require "Routes/Sales.php";
require "Routes/WarehouseAdmin.php";
require "Routes/Owner.php";
require "Routes/Administrator.php";
require "Routes/Products.php";
require "Routes/SalesAPI.php";
require "Routes/testAPI.php";
require "Routes/API/ProductsAPI.php";
require "Routes/API/Point.php";
require "Routes/API/Sales.php";
require "Routes/API/Contacts.php";
require "Routes/API/Token.php";
require "Routes/API/Delivery.php";
require "Routes/API/Purchase.php";
require "Routes/API/ApiKey.php";
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
