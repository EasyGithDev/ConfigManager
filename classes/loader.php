<?php

namespace ConfigManager;

class Loader
{
    const DEFAULT_SEP = '.';
    const DEFAULT_DIR = 'config';

    private static $_instance = null;

    protected $container = [];
    protected $dir = self::DEFAULT_DIR;
    protected $sep = self::DEFAULT_SEP;

    private function __construct()
    {
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
            throw new KeyExist($kFile);
        }

        return $this->getKey($kList, $this->container[$kFile]);
    }

    protected function keyList(string $str, string $sep = self::DEFAULT_SEP): array
    {
        $str = rtrim(trim($str), $sep);
        if (empty($str)) {
            throw new KeyEmpty();
        }
        return explode($sep, $str);
    }

    protected function getKeyFile(array &$kList): string|bool
    {
        if (!count($kList)) {
            throw new KeyFile();
        }
        return array_shift($kList);
    }

    protected function keyFile2Filepath($keyFile): string
    {
        return $this->getDir() . '/' . mb_strtolower($keyFile) . '.php';
    }

    protected function loadConfigurationFile(string $key, string $filename): void
    {
        if (!file_exists($filename)) {
            throw new FileNotFound($filename);
        }

        $this->container[$key] = require $filename;
    }

    protected function getKey($kList, $conf)
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
