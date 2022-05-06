<?php namespace Model {

    class RockBandModel{

        /**
         * @var array
         */
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

        /**
         * @param $getData
         * @return bool|mixed
         */
        public static function convert_format($getData)
        {
            if (self::check_data($getData)) {

                $data = self::format_data($getData);

                if (self::confirm_line($data)) {

                    return $data ;
                }
            }

            return false ;
        }

        /**
         * @param $getData
         * @return bool
         */
        private static function check_data($getData)
        {
            if(!isset($getData[0]))
                return false;

            if(empty($getData[0]))
                return false;

            if(is_null($getData[0]))
                return false;

            return true ;
        }

        /**
         * @param $getData
         * @return mixed
         */
        private static function format_data($getData){

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
        private static function confirm_line($data){

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
                $array_set[$index] = " `$name` = :$name " ;

            return implode(',', $array_set) ;
        }


    }
}
