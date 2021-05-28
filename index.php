<?php

define('__ROOT__', dirname(__FILE__));

require_once(__ROOT__ . '/src/controllers/Controller.php');

Controller::display($_GET);


