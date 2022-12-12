<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\FileNotFound;
use ConfigManager\Loader;

try {

    $port = (Loader::getInstance())
        ->setDir(__DIR__ . '/../config')
        ->setSep('_')
        ->app_lang;

    var_dump($port);
} catch (FileNotFound $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
