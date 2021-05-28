<?php 

    require_once(__DIR__ . './../models/Mangas.php');

    $mangas = new Mangas();

    $mangas = $mangas->getMangas();

    foreach ($mangas as $manga) {
        echo $manga['name'] . '<br>';
        echo '<a href="add-to-my-library.php?mangaId=' . $manga['id'] . '">Add to my reading</a><br>';
    }

