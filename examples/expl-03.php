<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Config;

$portR = (Config::getInstance())
    ->setSep('_')
    ->bdd_read_port;

$portW = (Config::getInstance())
    ->setSep('§')
    ->bdd§write§port;

var_dump($portR, ' ', $portW);
