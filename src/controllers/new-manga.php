<?php
require_once(__DIR__ . './../models/Manga.php');


if (isset($_POST['submit'])) {
    // control name of img 
    if ($_FILES['img']['name'] == '') {
        $img = 'default.jpg';
    } else {
        $img = $_FILES['img']['name'];
    }
    //check if Manga already exist in bdd
    //stock data from form
    $mangaValues = [
        'name' => htmlentities($_POST['name'], ENT_QUOTES),
        'author' => htmlentities($_POST['author'], ENT_QUOTES),
        'editor' => htmlentities($_POST['editor'], ENT_QUOTES),
        'tomes' => htmlentities($_POST['tomes'], ENT_QUOTES),
        'resume' => htmlentities($_POST['resume'], ENT_QUOTES),
        'img' => $img
    ];
    //create new object Manga with data from form parameters
    $manga = new Manga($mangaValues['name'], $mangaValues['author'], $mangaValues['editor'], $mangaValues['tomes'], $mangaValues['img'], $mangaValues['resume']);
    //function to check if Manga or exist in bdd
    $checkManga = $manga->checkManga();

    // create manga only if checkmanga dosnt return result from bdd
    if ($checkManga === true) {
        // move the img file in good folder
        if ($_FILES['img']['name'] != '') {
            move_uploaded_file($_FILES['img']['tmp_name'], './../public/img/dist/' . $mangaValues['img']);
        }
        // create manga in bdd
        $createManga = $manga->createManga();
        if ($createManga === true) {
            @session_start();
            $_SESSION['msg'] = 'Manga added !';
            header('Location: manga-administration');
            exit;
        } else {
            @session_start();
            $_SESSION['msg'] = 'We fail to add this manga ! Please try again, if the problem persist contact us.';
            header('Location: manga-administration');
            exit;
        }
    } else {
        echo $checkManga;
    }
}
