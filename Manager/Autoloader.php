<?php namespace Manager {

    /**
     * Class Autoloader
     * @package Manager
     */
    class Autoloader
    {
        /**
         * enregistre la fonction Autoloader::call() comme fonction de chargement par défaut
         */
        public static function register() {

            /**
             * __CLASS__ constante de la classe courante
             */
            spl_autoload_register(array(__CLASS__,"call"));

        }

        /**
         * etablit le chemin du fichier $file_name et l'inclut automatiquement
         * verifie la classe $class_name
         * interromp le traitement en cas d'absence de la classe
         * @param $class_name
         */
        private static function call($class_name){

            $_ROOT = realpath(dirname(__DIR__));

            $file_name = str_replace("\\","/", $class_name);

            if(file_exists($_ROOT."/".$file_name.".php"))
                require $_ROOT."/".$file_name.".php";

            if (class_exists($class_name))
                return true;

            return false ;
        }
    }
}