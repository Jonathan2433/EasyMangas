<?php
    spl_autoload_register(function($class){
        $name = str_replace('\\', '/', $class);
        require('src/'.$name.'.php');
    });
