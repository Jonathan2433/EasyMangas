<?php
require_once(__DIR__ . './../models/Manga.php');


if (isset($_POST['submit'])) {
    // control name of img 
    if ($_FILES['img']['name'] == '') {
        $img = 'default.jpg';
    } else {
        $img = $_FILES['img']['name'];
    }
    //stock data from form
    $mangaValues = [
        'name' => htmlentities($_POST['name'], ENT_QUOTES),
        'author' => htmlentities($_POST['author'], ENT_QUOTES),
        'editor' => htmlentities($_POST['editor'], ENT_QUOTES),
        'tomes' => htmlentities($_POST['tomes'], ENT_QUOTES),
        'resume' => htmlentities($_POST['resume'], ENT_QUOTES),
        'img' => $img,
        'id' => $_POST['idManga'],
    ];
    //create new object Mangas with data from form parameters
    $manga = new Manga($mangaValues['name'], $mangaValues['author'], $mangaValues['editor'], $mangaValues['tomes'], $mangaValues['img'], $mangaValues['resume']);
    $checkManga = $manga->checkManga();

    // edit manga only if checkmanga dosnt return result from bdd
    if ($checkManga === true) {
        $editManga = $manga->editManga($mangaValues['id']);
        if($_FILES['img']['name'] != ''){
            move_uploaded_file($_FILES['img']['tmp_name'], __DIR__ . ' ./../../public/img/dist/' . $mangaValues['img']);
            if($manga['img'] != 'default.jpg'){
                /**
                 * unlink permet de supprimer un fichier
                 * Nous supprimons l'ancienne image si ce n'est pas default.jpg
                 */
                unlink(__DIR__ . ' ./../../public/img/dist/' . $manga['img']);
            }
        }    
        if ($editManga === true) {
            @session_start();
            $_SESSION['msg'] = 'Manga edited !';
            header('Location: manga-administration');
            exit;
        } else {
            @session_start();
            $_SESSION['msg'] = 'We failed to edit this manga ! Please try again, if the problem persist contact us.';
            header('Location: manga-administration');
            exit;
        }
    } else {
        echo $checkManga;
    }
}