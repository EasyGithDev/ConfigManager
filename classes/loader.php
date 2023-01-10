<?php

namespace ConfigManager;

interface Loader
{
    public function loadConfig(string $key, string $filename): array;
}
