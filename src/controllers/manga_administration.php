<?php
require_once(__DIR__ . './../models/Mangas.php');

$mangas = new Mangas();

$getMangas = $mangas->getMangas();
if (isset($_GET['idMangaToDelete'])) {
    $idManga = $_GET['idMangaToDelete'];
    $deleteManga = $mangas->deleteManga($idManga);
    if ($deleteManga) {
        $msg = 'Manga deleted !';
        ////////////////////////////ADD REROOT WHIT MSG ////////////////////
    } else {
        $msg = 'Manga delete fail, please contact an admin.';
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