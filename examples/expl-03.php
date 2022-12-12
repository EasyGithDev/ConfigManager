<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Loader;

$port = (Loader::getInstance())
    ->setDir(__DIR__ . '/../config')
    ->setSep('_')
    ->bdd_read_port;

var_dump($port);
