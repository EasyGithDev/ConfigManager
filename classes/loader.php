<?php

namespace ConfigManager;

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
            $loader = Loader::getInstance();
            $strKey = $arguments[0];
            return $loader->$strKey;
        }
        return false;
    }

    public function __get($key)
    {
        $kList = $this->keyList($key, $this->sep);

        if (!array_key_exists($key, $this->container)) {
            $kFile = $this->getKeyFile($kList);
            $filename = $this->keyFile2Filepath($kFile);
            $this->loadConfigurationFile($kFile, $filename);
        }

        if (!array_key_exists($kFile, $this->container)) {
            return false;
        }

        return $this->getKey($kList, $this->container[$kFile]);
    }

    public function keyList(string $str, string $sep = self::DEFAULT_SEP): array
    {
        $str = rtrim(trim($str), $sep);
        if (empty($str)) {
            throw new KeyEmpty();
        }
        return explode($sep, $str);
    }

    public function getKeyFile(array &$kList): string|bool
    {
        if (!count($kList)) {
            throw new KeyFile();
        }
        return array_shift($kList);
    }

    public function keyFile2Filepath($keyFile): string
    {
        return $this->getDir() . '/' . mb_strtolower($keyFile) . '.php';
    }

    function loadConfigurationFile(string $key, string $filename): void
    {
        if (!file_exists($filename)) {
            throw new FileNotFound($filename);
        }

        $this->container[$key] = require $filename;
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
