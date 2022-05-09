<?php namespace Manager {

    use Model\RockBandModel;

    class RockBandManager {
	
	    /**
	     * @param $data
	     * @param $id
	     *
	     * @return string
	     */
	    public function save_edit($data,$id)
	    {
		    $set = Autoloader::getInstance()->model("RockBand")->str_setSQL();
		
		    $band = $this->get_rock($id);
		    
		    $data["id"] = $band->id;
		    $data["city"] = $band->country_id;
		    $data["country"] = $band->city_id;
		    
		    $sql = "update `rock_band` set " . $set . " where `id` = :id ;";
		    
		    return Autoloader::getInstance()->manager("DataBase")->execute($sql,$data);
	    }
    	
        /**
         * enregistre/met à jour la ligne en base de données et retourne l'ID associé
         * @param $data
         * @var $red
         * @var RockBandModel $model
         * @var DataBaseManager $db
         * @return string
         */
        public function save_band($data){

            $band = $this->get_band($data["name"]);
            $country_id = $this->get_country($data["country"]);
            $city_id = $this->get_city($data["city"],$country_id);

            $set = Autoloader::getInstance()->model("RockBand")->str_setSQL();

            $data["city"] = $city_id;
            $data["country"] = $country_id;
            
            if ($band !== false) {
                $data["id"] = $band->id;
                $sql = "update `rock_band` set " . $set . " where `id` = :id ;";

            } else
                $sql = "insert into `rock_band` set " . $set." ;";

            Autoloader::getInstance()->manager("DataBase")->execute($sql,$data);

            return  (($band !== false) ? $band->id :  Autoloader::getInstance()->manager("DataBase")->lastInsertId());
        }

        /**
         * supprime le enregistrement qui ne sont pas dans la liste
         * @param $exists
         * @var DataBaseManager $db
         * @return count delete
         */
        public function remove_band($exists){

            $sql_del = "delete from `rock_band` where `id` not in ( :" . implode(', :', array_keys($exists) ) . ");";

            $sth_del = Autoloader::getInstance()->manager("DataBase")->execute($sql_del,$exists);

            return $sth_del->rowCount();
        }

        /**
         * verification de l'enregistrement en base
         * @param string $name
         * @var DataBaseManager $db
         * @return int rock_band_id
         */
        private function get_band($name){

            $sql = "select `id` from `rock_band` where `name` = :name ;";
            $data = ['name' => $name ];

            return Autoloader::getInstance()->manager("DataBase")->result(true , $sql, $data);

        }
	
	    /**
	     * @param $name
	     *
	     * @return int country_id
	     */
        private function get_country($name){

            $sql = "select `id` from `country` where `name` = :name ;";
            $data = ['name' => $name ];

            $country = Autoloader::getInstance()->manager("DataBase")->result(true , $sql, $data);

            if($country !== false ){
                return $country->id ;
            }

            $sql = "insert into `country` set `name` = :name ;";

            Autoloader::getInstance()->manager("DataBase")->execute($sql,$data);

            return Autoloader::getInstance()->manager("DataBase")->lastInsertId();

        }
	
	    /**
	     * @param $name
	     * @param $country_id
	     *
	     * @return int city_id
	     */
        private function get_city($name,$country_id){

            $sql = "select `id` from `city` where `name` = :name and `country_id` = :country_id ;";
            $data = ['name' => $name , 'country_id' => $country_id ];

            $city = Autoloader::getInstance()->manager("DataBase")->result(true , $sql, $data);

            if($city !== false ){
                return $city->id ;
            }

            $sql = "insert into `city` set `name` = :name, country_id = :country_id ;";

            Autoloader::getInstance()->manager("DataBase")->execute($sql,$data);

            return Autoloader::getInstance()->manager("DataBase")->lastInsertId();

        }
        
        /**
         * list enregistrement
         * @var DataBaseManager $db
         * @return array rock_band
         */
        public function list_band()
        {
	        $sql_list = "select `id`, `name` ,`start_year` from `rock_band` ;";
	        
            return Autoloader::getInstance()->manager("DataBase")->result(false , $sql_list);
        }
	
	    /**
	     * @param $id
	     *
	     * @return array|mixed
	     */
	    public function get_rock($id)
	    {
		    $sql_list = "select r.id, r.name ,
                            r.start_year,
                            r.end_year ,
                            r.founder,
                            r.member_count ,
                            r.music_type ,
                            r.presentation ,
                            co.name as country, co.id as country_id ,
                            ci.name as city, ci.id as city_id
                from `rock_band` r
                left join city ci on ci.id = r.city
                left join country co on co.id = r.country and ci.country_id = co.id
                where r.id = :id
            ;";
		
		    $data = ['id' => $id ];
		    
		    return Autoloader::getInstance()->manager("DataBase")->result(true , $sql_list , $data);
	    }
	
	    /**
	     * @param $id
	     *
	     * @return int
	     */
	    public function remove_rock($id){
		
		    $sql_del = "delete from `rock_band` where `id` =  :id ;";
		
		    $data = ['id' => $id ];
		
		    $sth_del = Autoloader::getInstance()->manager("DataBase")->execute($sql_del,$data);
		
		    return $sth_del->rowCount();
	    }
    }
}
