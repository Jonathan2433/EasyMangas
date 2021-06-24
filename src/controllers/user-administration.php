<?php
require_once(__DIR__ . './../models/Users.php');

$users = new Users();

$getUsers = $users->getUsers();
if (isset($_GET['idUserToDelete'])) {
    $idUser = $_GET['idUserToDelete'];
    $deleteUser = $users->deleteUser($idUser);
    if ($deleteUser) {
        @session_start();
        $_SESSION['msg'] = 'User deleted with success!';
        header('Location: user-administration');
        exit;
    } else {
        @session_start();
        $_SESSION['msg'] = 'We failed to delete this user, please try again ! if this problem persist please contact us.';
        header('Location: user-administration');
        exit;
    }
}
