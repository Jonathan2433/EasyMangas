<?php
session_start();

require_once('../autoload.php');
// require_once('../src/controllers/acl.php');

// define('DIR_CTRL', __DIR__ . '/src/controllers');
// define('LAYOUT', __DIR__ . '/src/views/template/layout.phtml'); obsolete car use autoload
if (isset($_SERVER['REDIRECT_URL'])) {
    $currentUrl = $_SERVER['REDIRECT_URL'];
} else {
    $currentUrl = $_SERVER['REQUEST_URI'];
}
if ($currentUrl === '/easymanga/') {
    $currentUrl = '/';
}
$pathView = '/../src/views/';
$pathCtrl = '/../src/controllers/';

$routes = [
    'add-to-library'   => $pathCtrl . 'add-to-library.php',
    'delete-to-library'   => $pathCtrl . 'delete-to-library.php',
    'manga_administration'   => $pathCtrl . 'manga_administration.php',
    'user-administration'   => $pathCtrl . 'user-administration.php',
    '/'   => $pathView . 'index.phtml',
    'index'   => $pathView . 'index.phtml',
    'login'   => $pathView . 'login.phtml',
    'logout'   => $pathView . 'logout.phtml',
    'manga-administration'    => $pathView . 'manga-administration.phtml',
    'manga-edit'    => $pathView . 'manga-edit.phtml',
    'new-manga'    => $pathView . 'new-manga.phtml',
    'subscribe'    => $pathView . 'subscribe.phtml',
    'user-administration'    => $pathView . 'user-administration.phtml',
    'user-edit'    => $pathView . 'user-edit.phtml',
    'test-detailmanga'    => $pathView . 'test-detailmanga.phtml',
    'test-detailuser'    => $pathView . 'test-detailuser.phtml',
    'library-user'    => $pathView . 'library-user.phtml',
    '/404'    => $pathView . '404.phtml',
];
if ($currentUrl != '/') {
    $currentUrl = basename($currentUrl);
}
if (!isset($routes[$currentUrl])) {
    $currentUrl = '/404';
}
require_once(__DIR__ . $routes[$currentUrl]);
