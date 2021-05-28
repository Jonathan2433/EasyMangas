<?php

require_once(__DIR__ . './../models/Library.php');
$test = new Library();

$getLibrary = $test->getLibrary();

foreach ($getLibrary as $library) {
    echo $library['pseudo'] . ' : ';
    echo $library['name'] . '<br>';
}
