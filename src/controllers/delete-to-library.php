<?php
$userId = $_SESSION['user']['id'];
require_once(__DIR__ . './../models/Library.php');
$deleteToLibrary = new Library();

if (isset($userId, $_GET['mangaId'])) {
    $mangaId = $_GET['mangaId'];
    
    $deleteToLibrary->deleteReading($userId, $mangaId);
    
    if ($deleteToLibrary) {
        @session_start();
        $_SESSION['msg'] = 'Manga deleted to your library with success!';
        header('Location: library-user');
        exit;
    } else {
        @session_start();
        $_SESSION['msg'] = 'We failed to delete this manga to your library, please try again ! if this problem persist please contact us.';
        header('Location: library-user');
        exit;
    }
}

