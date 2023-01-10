<?php

namespace ConfigManager;

class JsonLoader implements Loader
{
    public static $_extension = '.json';

    public function loadConfig(string $key, string $filename): array
    {
        if (!file_exists($filename)) {
            throw new FileNotFound($filename);
        }

        $content = file_get_contents($filename);
        $conf = json_decode($content, true);

        if (!is_array($conf)) {
            throw new InvalidConfigFile();
        }

        return $conf;
    }
}
