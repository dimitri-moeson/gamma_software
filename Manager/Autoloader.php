<?php namespace Manager {

    use Controller\RockBandController;
    use Model\RockBandModel;
    use View\RockBandView;

    /**
     * Class Autoloader
     * @package Manager
     */
    class Autoloader
    {
        /**
         * enregistre la fonction Autoloader::call() comme fonction de chargement par défaut
         */
        public function register() {

            spl_autoload_register(array(__CLASS__,"call"));
        }

        /**
         * @param $class_name
         * @return bool
         */
        private function call($class_name){

            $_ROOT = realpath(dirname(__DIR__));

            $file_name = str_replace("\\","/", $class_name);

            if(file_exists($_ROOT."/".$file_name.".php"))
                require $_ROOT."/".$file_name.".php";

            if (class_exists($class_name))
                return true;

            return false ;
        }

        private static $_instance ;

        public static function getInstance():Autoloader
        {
            if(is_null(self::$_instance)){
                self::$_instance = new Autoloader();
            }
            return self::$_instance;
        }

        /**
         * @param $name
         * @param array $options
         * @param string $type
         * @return bool
         */
        private function instance($name,$options = [],$type = "manager"){

            $classe_name = ucfirst($type)."\\".ucfirst($name). ucfirst($type);

            if(class_exists($classe_name))
            {
                if (!is_callable(array($classe_name, "__construct")))
                {
                    if (is_callable(array($classe_name, "getInstance")))
                    {
                        //var_dump("singleton $classe_name");
                        return $classe_name::getInstance($options);
                    }
                }

                //var_dump("instance $classe_name");
                return new $classe_name($options) ;
            }

            return false ;
        }

        /**
         * @param $name
         * @param array $options
         * @return RockBandController
         */
        public function controller($name,$options = [])
        {
            return $this->instance($name,$options, "controller");
        }

        /**
         * @param $name
         * @param array $options
         * @return RockBandView
         */
        public function view($name,$options = [])
        {
            return $this->instance($name,$options, "view");
        }

        /**
         * @param $name
         * @param array $options
         * @return RockBandModel
         */
        public function model($name,$options = [])
        {
            return $this->instance($name,$options, "model");
        }

        /**
         * @param $name
         * @param array $options
         * @return RockBandManager
         */
        public function manager($name,$options = [])
        {
            return $this->instance($name,$options, "manager");
        }
    }
}