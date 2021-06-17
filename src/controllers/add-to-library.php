<?php
$userId = $_SESSION['user']['id'];
require_once(__DIR__ . './../models/Library.php');
$addLibrary = new Library();


if (isset($userId, $_GET['mangaId'])) {
    $mangaId = $_GET['mangaId'];

    $addLibrary->addReading($userId, $mangaId);

    if ($addLibrary) {
        @session_start();
        $_SESSION['msg'] = 'Manga added to your library with success!';
        header('Location: index');
        exit;
    } else {
        @session_start();
        $_SESSION['msg'] = 'We failed to add this manga in your library, please try again ! if this problem persist please contact us.';
        header('Location: index');
        exit;
    }
}

