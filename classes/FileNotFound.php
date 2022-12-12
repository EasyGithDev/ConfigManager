<?php

namespace ConfigManager;

class FileNotFound extends \Exception
{
    public function __construct($filename)
    {
        parent::__construct("File not found : $filename");
    }
}
