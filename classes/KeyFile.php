<?php

namespace ConfigManager;

class KeyFile extends \Exception
{
    public function __construct()
    {
        parent::__construct("There is no key file");
    }
}
