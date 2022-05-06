<?php namespace Manager;


class ConfigManager
{
    private static $_instance ;
    private $settings = array();

    /**
     * Instance unique de App
     * @return ConfigManager
     */
    public static function getInstance():ConfigManager
    {
        if(is_null(self::$_instance))
            self::$_instance = new ConfigManager();
        
        return self::$_instance;
    }

    /**
     * App constructor.
     * importe e fichier de config
     * @param $file
     */
    private function __construct()
    {
        $config_file = realpath(__DIR__ . "/../config/config.ini");

        if(!file_exists($config_file))
            die("not config file : ".$config_file);

        $this->settings = parse_ini_file( $config_file , true);

        if($this->option("reporting","error"))
            ini_set('error_reporting', E_ALL);
        

        if($this->option("display","error"))
            ini_set('display_errors', true);
    }

    /**
     * @return bool
     */
    public function exists($key, $dom = "database")
    {
        $hasBase = array_key_exists($dom, $this->settings);

        if($hasBase)
        {
            $hasKeys = array_key_exists($key, $this->settings[$dom]);

            if ($hasKeys ) return true ;

            if (!$hasKeys ) return false ;
        }


        return false ;
    }

    /**
     * @param $key
     * @param string $dom
     * @return boolean|string
     */
    public function param( $key, $dom = "database" ): ?string
    {
        if (!$this->exists($key, $dom)) {
            throw new Exception("Missing config [$dom/$key] informations");
        }

        return $this->settings[$dom][$key];
    }

    /**
     * @param $key
     * @param string $dom
     * @return string|boolean
     */
    public function option( $key, $dom = "database" ): ?string
    {
        if ($this->exists($key, $dom))
            return $this->settings[$dom][$key];

        return false ;
    }

}