<?php

namespace ConfigManager;

class KeyExist extends \Exception
{
    public function __construct($key)
    {
        parent::__construct("The key $key does not exist in the container");
    }
}
