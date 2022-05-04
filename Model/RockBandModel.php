<?php namespace Model {

    class RockBandModel{

        private static $data_model = array(

            "name" ,
            "country",
            "city",
            "start_year",
            "end_year" ,
            "founder",
            "member_count" ,
            "music_type" ,
            "presentation"

        );

        private static $error_model = array(

            0 => 'le téléchargement est correct',
            1 => 'La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini',
            2 => 'La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML',
            3 => 'Le fichier n\'a été que partiellement téléchargé',
            4 => 'Aucun fichier n\'a été téléchargé',
            6 => 'Un dossier temporaire est manquant',
            7 => 'Échec de l\'écriture du fichier sur le disque.',
            8 => 'Une extension PHP a arrêté l\'envoi de fichier.',
            9 => "le fichier XLSX est invalide"
        );

        public static function getErr($index)
        {
            if(array_key_exists($index,self::$error_model))
                return self::$error_model[$index];
        }

        /**
         * @param $getData
         * @return mixed
         */
        public static function format_data($getData){

            $data = [];

            foreach (self::$data_model as $index => $name)
                $data[$name] = $getData[$index]!="" ? $getData[$index] : null  ;

            return $data ;

        }

        /**
         * la ligne du fichier contient au moins le nom du groupe
         * @param $data
         * @return bool
         */
        public static function confirm_line($data){

            if(isset($data["name"])){

                if(!empty($data["name"])) {

                    if(!is_null($data["name"])) {

                        return true;
                    }
                }
            }



            return false ;
        }

        /**
         * @param $data
         * @return string
         */
        public static function nullable($data){

            return ( $data == 0 || $data == null  ? "" : $data) ;
        }

        /**
         * @return string
         */
        public static function str_setSQL(){

            $array_set = [];
            foreach (self::$data_model as $index => $name)
                $array_set[$index] = "$name = :$name" ;

            return implode(',', $array_set) ;
        }


    }
}
