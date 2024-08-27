<?php

spl_autoload_register(function ($class) {
    include realpath(dirname(__FILE__),2) . '/models' . $class . '.class.php';
});
