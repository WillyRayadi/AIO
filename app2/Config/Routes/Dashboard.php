<?php
$routes->get('/dashboard', 'Dashboard::dashboard');
$routes->get('/data_dashboard', "Dashboard::data_dashboard");
$routes->get('data_supervisor', "Dashboard::dashboard_supervisor");
$routes->get('/cek_alert',"Dashboard::cek_alert");

$routes->get("/settings","Dashboard::settings");
$routes->post("/settings/save","Dashboard::settings_save");
$routes->post("/settings/add_team","Dashboard::save_team");
$routes->get("/settings/team/(:num)/delete", "Dashboard::delete_team/$1");

$routes->get("ajax/get/all/bonus", "Dashboard::getAllAchievement");
$routes->get("pages/test", "Dashboard::Testing");
?>