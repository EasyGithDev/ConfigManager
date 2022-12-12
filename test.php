<?php

require_once __DIR__ . '/classes/loader.php';

// (Loader::getInstance())->setDir(__DIR__ . '/conf');
// (Loader::getInstance())->setDir(__DIR__ . '/conf')->setSep('-');

$host = Loader::get('bdd.write');
var_dump($host);
