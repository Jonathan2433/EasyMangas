<?php
$userId = $_GET['userId'];
require_once(__DIR__ . './../models/Library.php');
$addLibrary = new Library();


if (isset($_GET['userId'], $_GET['mangaId'])) {
    $mangaId = $_GET['mangaId'];

    $addLibrary->addReading($userId, $mangaId);

    if ($addLibrary) {
        ////////////////////////////TODO ADD AJAX OR REROOT + MSG ADDING OK /////////////////////
        echo 'OK POTO  bien ajouter';
        header('Location: index');
    } else {
        ///////////////////////TODO ADD ERROR MSG + REROOT ////////////////////////////////////
        echo 'NOPE MON BRO';
        header('Location: index');
    }
}

