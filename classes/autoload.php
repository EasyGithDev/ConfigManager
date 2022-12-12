<?php

namespace ConfigManager;

spl_autoload_register(function ($classname) {

    $classname =    str_replace(__NAMESPACE__, '', $classname);
    $classname =    str_replace('\\', '', $classname);
   
    include __DIR__ . '/' . $classname . '.php';
});