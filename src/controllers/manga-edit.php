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
        'name' => $_POST['name'],
        'author' => $_POST['author'],
        'editor' => $_POST['editor'],
        'tomes' => $_POST['tomes'],
        'resume' => $_POST['resume'],
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
            move_uploaded_file($_FILES['img']['tmp_name'], __DIR__ . ' ./../../public/img/dist/' . $image);
            if($manga['img'] != 'default.jpg'){
                /**
                 * unlink permet de supprimer un fichier
                 * Nous supprimer l'ancienne image si ce n'est pas default.jpg
                 */
                unlink(__DIR__ . ' ./../../public/img/dist/' . $manga['img']);
            }
        }    
        if ($editManga === true) {
            echo ('Manga edited !');
            header('Location: index');
        } else {
            echo ('something wrong happend ! please contact an admin.');
            header('Location: index');
        }
    } else {
        echo $checkManga;
    }
}