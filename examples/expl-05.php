<?php

require_once __DIR__ . '/../classes/autoload.php';

use ConfigManager\Config;
use ConfigManager\JsonLoader;

$portR = (Config::getInstance())
    ->setSep('_')
    ->setLoader(JsonLoader::class)
    ->bdd_read_port;

var_dump($portR);

$defaultLang = Config::get('lang_default');
$fallbackLang = Config::get('lang_fallback');

var_dump($defaultLang, ' ', $fallbackLang);
