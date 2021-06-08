<?php
if (isset($_POST['login'])) {
    require_once(__DIR__ . '/../models/Users.php');
    $user = new Users();
    $user = $user->getUserFromLogin($_POST['email'], $_POST['password']);
    if ($user == false) {
        return $errorMsg = 'Echec de connexion, veuillez vérifiez vos paramétres de connexion !';
        header('Location: login');
        exit;
    } else {
        session_start();
        $_SESSION['user'] = $user;
        header('Location: index');
        exit;
    }
}
