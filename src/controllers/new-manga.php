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
        'name' => $_POST['name'],
        'author' => $_POST['author'],
        'editor' => $_POST['editor'],
        'tomes' => $_POST['tomes'],
        'resume' => $_POST['resume'],
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
            move_uploaded_file($_FILES['img']['tmp_name'], './../../public/img/dist/' . $image);
        }
        // create manga in bdd
        $createManga = $manga->createManga();
        if ($createManga === true) {
            echo ('manga added !');
        } else {
            echo ('something wrong happend ! please contact an admin.');
        }
    } else {
        echo $checkManga;
    }
}
