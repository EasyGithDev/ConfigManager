<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Loader;

$portR = (Loader::getInstance())
    ->setDir(__DIR__ . '/../config')
    ->setSep('_')
    ->bdd_read_port;

$portW = (Loader::getInstance())
    ->setSep('§')
    ->bdd§write§port;

var_dump($portR, ' ', $portW);
