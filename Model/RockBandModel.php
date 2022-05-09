<?php namespace Model {

    class RockBandModel{

        /**
         * @var array
         */
        private $data_model = array(

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
        public function convert_format($getData) : array {
        	
            if ($this->check_data($getData)) {

                $data = $this->format_data($getData);

                if ($this->confirm_line($data))
                    return $data ;
                
            }

            return false ;
        }

        /**
         * @param $getData
         * @return bool
         */
        private function check_data($getData) : bool {
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
        private function format_data($getData) : array {

            $data = [];

            foreach ($this->data_model as $index => $name)
                $data[$name] = $getData[$index]!="" ? $getData[$index] : null  ;

            return $data ;

        }

        /**
         * la ligne du fichier contient au moins le nom du groupe
         * @param $data
         * @return bool
         */
        private function confirm_line($data) : bool {

            if(isset($data["name"]))
                if(!empty($data["name"]))
                    if(!is_null($data["name"]))
                        return true;
            
            return false ;
        }

        /**
         * @param $data
         * @return string
         */
        public function nullable($data) : string {

            return ( $data == 0 || $data == null  ? "" : $data) ;
        }

        /**
         * @return string
         */
        public function str_setSQL() : string {

            $array_set = [];
            foreach ($this->data_model as $index => $name)
                $array_set[$index] = " `$name` = :$name " ;

            return implode(',', $array_set) ;
        }
	
	    public function make_setSQL($datas) : string {
		
		    $array_set = [];
		    foreach ($datas as $key => $val)
			    $array_set[] = " `$key` = :$key " ;
		
		    return implode(',', $array_set) ;
	    }
	
	    public function format_post($getData) : array {
		
		    $data = [];
		
		    foreach ($this->data_model as $v)
			    $data[$v] = $getData[$v]!="" ? $getData[$v] : null  ;
		
		    return $data ;
		
	    }
    }
}
