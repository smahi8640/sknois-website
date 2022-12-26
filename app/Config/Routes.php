<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function( $message = null )
{
    $data = [
        'title' => '404 - Page not found',
        'message' => $message,
    ];
    echo view('frontend/pages/404');
});
$routes->setAutoRoute(true);

$routes->add('admin','Admin/User::login');
/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//$routes->get('categories/index/(:any)', 'Categories::index/$1');
//$routes->get('products/(:any)', 'Products::productdetail/$1');
$routes->get('jewelry/(:any)', 'Categories::products/$1');
$routes->get('products/all', 'Products::index');
$routes->get('products/getsearchedproducts', 'Products::getsearchedproducts');
$routes->get('products/searchajax/(:any)', 'Products::searchajax/$1');
$routes->get('products/(:any)', 'Products::productdetail/$1');

$routes->get('products_set/(:any)', 'Products_set::productdetail/$1');
$routes->post('products/stockajax', 'Products::stockajax');
$routes->post('search', 'Search::index');
$routes->get('search', 'Search::index');
$routes->get('products-sitemap.xml','Sitemap::products');
$routes->get('productscats-sitemap.xml','Sitemap::category');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
