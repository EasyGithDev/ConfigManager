<?php

namespace ConfigManager;

class InvalidConfigFile extends \Exception
{
    public function __construct()
    {
        parent::__construct("Config file must return an array");
    }
}
