<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Loader;

$hostR = Loader::get('bdd-read-host', '-');
$hostW = Loader::get('bdd-write-host');
$dbnameW = Loader::get('bdd.write.dbname', '.');
var_dump($hostR, ' ', $hostW, ' ', $dbnameW);
