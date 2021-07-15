<?php
    $userId = $_SESSION['user']['id'];

    require_once(__DIR__ . './../models/Library.php');
    $library = new Library();

    $mangas = $library->getLibrary($userId);

    if (isset($_POST['submit'])) {
        $userTomesRead = $_POST['user-tomes-read'];
        $mangaId = $_POST['id-manga'];

        $editTome = $library->editTome($mangaId, $userId, $userTomesRead);

        if ($editTome === true) {
            @session_start();
            $_SESSION['msg'] = 'Tomes readed edited !';
            header('Location: library-user');
            exit;
        } 
        @session_start();
        $_SESSION['msg'] = 'Edit tomes readed failed !Please try again, if the problem persist, contact us.';
        header('Location: library-user');
        exit;

    }
