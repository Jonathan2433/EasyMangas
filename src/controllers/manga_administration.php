<?php
require_once(__DIR__ . './../models/Mangas.php');

$mangas = new Mangas();

$getMangas = $mangas->getMangas();
if (isset($_GET['idMangaToDelete'])) {
    $idManga = $_GET['idMangaToDelete'];
    $deleteManga = $mangas->deleteManga($idManga);
    if ($deleteManga) {
        @session_start();
        $_SESSION['msg'] = 'Manga deleted !';
        header('Location: manga-administration');
        exit;
    } else {
        @session_start();
        $_SESSION['msg'] = 'We fail to delete this manga ! Please try again, if this problem persist, contact us.';
        header('Location: manga-administration');
        exit;
    }
}
// if (isset($_GET['role'])) {
//     $users = getUsersFromForm($_GET['role']);
//     $msgFilter = ('Filter by Role : ' . $_GET['role']);
//     if ($_GET['role'] == '*') {
//         $users = getUsers();
//     }
// }