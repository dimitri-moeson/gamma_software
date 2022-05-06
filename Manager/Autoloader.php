<?php namespace Manager {

    use Controller\RockBandController;
	use Manager\ConfigManager;
	use Manager\DataBaseManager;
	use Manager\RequestManager;
	use Model\RockBandModel;
	use Model\SqlModel;
	use Model\UploadModel;
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
            if(is_null(self::$_instance))
                self::$_instance = new Autoloader();
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

            if(class_exists($classe_name)) {
	            if ( ! is_callable ( [ $classe_name , "__construct" ] ) )
		            if ( is_callable ( [ $classe_name , "getInstance" ] ) )
			            return $classe_name ::getInstance ( $options );
	            
	            return new $classe_name( $options );
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
         * @return RockBandModel|UploadModel|SqlModel
         */
        public function model($name,$options = [])
        {
            return $this->instance($name,$options, "model");
        }

        /**
         * @param $name
         * @param array $options
         * @return RockBandManager|DataBaseManager|RequestManager|ConfigManager
         */
        public function manager($name,$options = [])
        {
            return $this->instance($name,$options, "manager");
        }
    }
}