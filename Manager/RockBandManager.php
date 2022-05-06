<?php namespace Manager {

    use Model\RockBandModel;

    class RockBandManager {


        /**
         * enregistre/met à jour la ligne en base de données et retourne l'ID associé
         * @param $data
         * @param $red
         * @var RockBandModel $model
         * @var DataBaseManager $db
         * @return string
         */
        public function save_band($data,$red){

            $set = Autoloader::getInstance()->model("RockBand")::str_setSQL();

            if ($red !== false) {

                $data["id"] = $red->id;
                $sql = "update `rock_band` set " . $set . " where `id` = :id ;";

            } else {

                $sql = "insert into `rock_band` set " . $set." ;";
            }

            Autoloader::getInstance()->manager("DataBase")->execute($sql,$data);

            return  (($red !== false) ? $red->id :  Autoloader::getInstance()->manager("DataBase")->lastInsertId());
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
        public function get_band($name){

            $sql = "select `id` from `rock_band` where `name` = :name ;";
            $data = ['name' => $name ];

            return Autoloader::getInstance()->manager("DataBase")->result(true , $sql, $data);

        }

        /**
         * list enregistrement
         * @var DataBaseManager $db
         * @return array rock_band
         */
        public function list_band()
        {
            $sql_list = "select * from `rock_band` ;";

            return Autoloader::getInstance()->manager("DataBase")->result(false , $sql_list);
        }
    }
}
