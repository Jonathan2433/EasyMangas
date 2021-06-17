<?php
$userId = $_SESSION['user']['id'];

require_once(__DIR__ . './../models/Library.php');
$library = new Library();

$mangas = $library->getLibrary($userId);

