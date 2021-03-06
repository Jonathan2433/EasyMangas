<?php
$userId = $_SESSION['user']['id'];
require_once(__DIR__ . '/../models/Library.php');

$addLibrary = new Library();


if (isset($userId, $_GET['mangaId'])) {
    $mangaId = $_GET['mangaId'];
    $checkLibrary = $addLibrary->checkLibrary($userId, $mangaId);
    if ($checkLibrary) {
        $tomesRead = 1;
        $addLibrary->addReading($userId, $mangaId, $tomesRead);
    
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
    } else {
        @session_start();
        $_SESSION['msg'] = 'You already have this manga in your libary.';
        header('Location: index');
        exit;
    }
}

