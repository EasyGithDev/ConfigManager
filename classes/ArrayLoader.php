<?php

namespace ConfigManager;

class ArrayLoader implements Loader
{
    public static $_extension = '.php';

    public function loadConfig(string $key, string $filename): array
    {
        if (!file_exists($filename)) {
            throw new FileNotFound($filename);
        }

        $conf = require $filename;

        if (!is_array($conf)) {
            throw new InvalidConfigFile();
        }

        return $conf;
    }
}
