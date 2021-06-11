<?php
session_start();

require_once('../autoload.php');
// require_once('../src/controllers/acl.php');

define('DIR_CTRL', __DIR__ . '/src/controllers');
define('LAYOUT', __DIR__ . '/src/views/template/layout.phtml');
if (isset($_SERVER['REDIRECT_URL'])) {
    $currentUrl = $_SERVER['REDIRECT_URL'];
} else {
    $currentUrl = $_SERVER['REQUEST_URI'];
}
if ($currentUrl === '/easymangas/') {
    $currentUrl = '/';
}

$routes = [
    '/'   => 'index.phtml',
    'index'   => 'index.phtml',
    'login'   => 'login.phtml',
    'logout'   => 'logout.phtml',
    'manga-administration'    => 'manga-administration.phtml',
    'manga-edit'    => 'manga-edit.phtml',
    'new-manga'    => 'new-manga.phtml',
    'subscribe'    => 'subscribe.phtml',
    'user-administration'    => 'user-administration.phtml',
    'user-edit'    => 'user-edit.phtml',
    'test-detailmanga'    => 'test-detailmanga.phtml',
    'test-detailuser'    => 'test-detailuser.phtml',
    '/404'    => '404.phtml',
];
if ($currentUrl != '/') {
    $currentUrl = basename($currentUrl);
}
if (!isset($routes[$currentUrl])) {
    $currentUrl = '/404';
}
require_once(__DIR__ . '/../src/views/' . $routes[$currentUrl]);
