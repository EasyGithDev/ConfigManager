<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Config;

$hostR = Config::get('bdd-read-host', '-');
$hostW = Config::get('bdd-write-host');
$dbnameW = Config::get('bdd.write.dbname', '.');
var_dump($hostR, ' ', $hostW, ' ', $dbnameW);
