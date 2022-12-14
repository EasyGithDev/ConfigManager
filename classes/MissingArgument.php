<?php

namespace ConfigManager;

class MissingArgument extends \Exception
{
    public function __construct()
    {
        parent::__construct("There must be at least 1 argument");
    }
}
