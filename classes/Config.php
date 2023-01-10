<?php

namespace ConfigManager;

class Config
{
    const DEFAULT_SEP = '.';
    const DEFAULT_DIR = 'config';
    const DEFAULT_LOADER = ArrayLoader::class;

    private static $_instance = null;

    protected $container = [];
    protected $loader = self::DEFAULT_LOADER;
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
            if (count($arguments) < 1) {
                throw new MissingArgument();
            }
            $loader = static::getInstance();
            $strKey = $arguments[0];
            if (isset($arguments[1])) {
                $loader->setSep($arguments[1]);
            }
            if (isset($arguments[2])) {
                $loader->setDir($arguments[2]);
            }
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
            $this->loadConfig($kFile, $filename);
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
        return $this->dir . '/' . mb_strtolower($keyFile) . $this->loader::$_extension;
    }

    protected function loadConfig(string $key, string $filename): void
    {
        $loader = new $this->loader; 
        $conf = $loader->loadConfig($key,  $filename);
        $this->container[$key] = $conf;
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
     * Set the value of dir
     *
     * @return  self
     */
    public function setDir(string $dir): Config
    {
        $this->dir = $dir;
        return $this;
    }

    /**
     * Set the value of sep
     *
     * @return  self
     */
    public function setSep(string $sep): Config
    {
        $this->sep = $sep;
        return $this;
    }

    /**
     * Set the value of loader
     *
     * @return  self
     */ 
    public function setLoader(string $loader) : Config
    {
        $this->loader = $loader;

        return $this;
    }
}
