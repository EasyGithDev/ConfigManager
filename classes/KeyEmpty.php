<?php

namespace ConfigManager;

class KeyEmpty extends \Exception
{
    public function __construct()
    {
        parent::__construct("There is no key to load");
    }
}
