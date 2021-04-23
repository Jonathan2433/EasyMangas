<?php
require_once(__DIR__ . './../models/Users.php');

$users = new Users();

$getUsers = $users->getUsers();
if (isset($_GET['idUserToDelete'])) {
    $idUser = $_GET['idUserToDelete'];
    $deleteUser = $users->deleteUser($idUser);
    if ($deleteUser) {
        $msg = 'User deleted !';
        ////////////////////////////ADD REROOT WHIT MSG ////////////////////
    } else {
        $msg = 'User delete fail, please contact an admin.';
                ////////////////////////////ADD REROOT WHIT MSG ////////////////////
    }
}
// if (isset($_GET['role'])) {
//     $users = getUsersFromForm($_GET['role']);
//     $msgFilter = ('Filter by Role : ' . $_GET['role']);
//     if ($_GET['role'] == '*') {
//         $users = getUsers();
//     }
// }