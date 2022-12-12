<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Loader;

(Loader::getInstance())
    ->setDir(__DIR__ . '/../config')
    ->setSep('-');

$hostR = Loader::get('bdd-read-host');
$hostW = Loader::get('bdd-write-host');
var_dump($hostR, ' ', $hostW);
