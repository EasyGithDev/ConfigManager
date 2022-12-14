<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Loader;

$hostR = Loader::get('bdd.read.host');
$hostW = Loader::get('bdd.write.host');
var_dump($hostR, ' ', $hostW);
