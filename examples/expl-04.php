<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\FileNotFound;
use ConfigManager\Config;

try {

    $lang = (Config::getInstance())
        ->setSep('_')
        ->app_lang;

    var_dump($lang);
} catch (FileNotFound $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
