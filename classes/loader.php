<?php

class Loader
{
    const DEFAULT_SEP = '.';
    const DEFAULT_DIR = 'config';
    protected $container = [];
    protected $dir = '';
    protected $sep = '';

    private static $_instance = null;

    private function __construct()
    {
        $this->dir = self::DEFAULT_DIR;
        $this->sep = self::DEFAULT_SEP;
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function __callStatic($name, $arguments)
    {
        if ($name == 'get') {
            $loader =     Loader::getInstance();
            $strKey = $arguments[0];
            return $loader->$strKey;
        }
        return false;
    }

    public function __get($key)
    {
        $kList = $this->kList($key, $this->sep);
        if (!$kList) {
            return false;
        }

        if (!array_key_exists($key, $this->container)) {
            $kFile = $this->getConfigurationFile($kList);
            if (!$kFile) {
                return false;
            }
            $filename = $this->getDir() . '/' . mb_strtolower($kFile) . '.php';
            $this->loadConfigurationFile($kFile, $filename);
        }

        if (!array_key_exists($kFile, $this->container)) {
            return false;
        }

        return $this->getKey($kList, $this->container[$kFile]);
    }

    public function kList(string $str, string $sep = self::DEFAULT_SEP): array|bool
    {
        $str = rtrim(trim($str), $sep);
        if (empty($str)) {
            return false;
        }
        return explode($sep, $str);
    }

    public function getConfigurationFile(array &$kList): string|bool
    {
        if (!count($kList)) {
            return false;
        }
        return array_shift($kList);
    }

    function loadConfigurationFile(string $key, string $filename): bool
    {
        if (!file_exists($filename)) {
            return false;
        }

        $this->container[$key] = require $filename;

        return true;
    }

    function getKey($kList, $conf)
    {
        while (count($kList) > 0) {
            $k = array_shift($kList);
            if (!array_key_exists($k, $conf)) {
                break;
            }
            $conf = $conf[$k];
        }
        return $conf;
    }

    /**
     * Get the value of dir
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * Set the value of dir
     *
     * @return  self
     */
    public function setDir(string $dir): Loader
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * Get the value of sep
     */
    public function getSep(): string
    {
        return $this->sep;
    }

    /**
     * Set the value of sep
     *
     * @return  self
     */
    public function setSep(string $sep): Loader
    {
        $this->sep = $sep;

        return $this;
    }
}
