<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Loader;

$portR = (Loader::getInstance())
    ->setSep('_')
    ->bdd_read_port;

$portW = (Loader::getInstance())
    ->setSep('§')
    ->bdd§write§port;

var_dump($portR, ' ', $portW);
