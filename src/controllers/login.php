<?php
if (isset($_POST['login'])) {
    require_once(__DIR__ . '/../models/Users.php');
    $users = new Users();
    $users = $users->getUserFromLogin(htmlentities($_POST['email'], ENT_QUOTES), htmlentities($_POST['password'], ENT_QUOTES));
    if ($users == false) {
        @session_start();
        $_SESSION['msg'] = 'Login failed, please check your connection settings !';
        header('Location: login');
        exit;
    } else {
        @session_start();
        $_SESSION['user'] = $users;
        header('Location: index');
        exit;
    }
}
