<?php

    require_once(__DIR__ . './../models/Mangas.php');

    $mangas = new Mangas();

    $mangas = $mangas->getMangas();

