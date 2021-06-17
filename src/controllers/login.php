<?php
if (isset($_POST['login'])) {
    require_once(__DIR__ . '/../models/Users.php');
    $users = new Users();
    $users = $users->getUserFromLogin(htmlentities($_POST['email'], ENT_QUOTES), htmlentities($_POST['password'], ENT_QUOTES));
    if ($users == false) {
        return $errorMsg = 'Echec de connexion, veuillez vérifiez vos paramétres de connexion !';
        header('Location: login');
        exit;
    } else {
        session_start();
        $_SESSION['user'] = $users;
        header('Location: index');
        exit;
    }
}
