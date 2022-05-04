<?php namespace Manager {

    use Model\RockBandModel;

    class RockBandManager {

        /**
         * enregistre/met à jour la ligne en base de données et retourne l'ID associé
         * @param $data
         * @param $red
         * @return string
         */
        public function save_band($data,$red){

            $set = RockBandModel::str_setSQL();

            if ($red !== false) {

                $data["id"] = $red->id;
                $sql = "update rock_band set " . $set . " where id = :id ";

            } else {

                $sql = "insert into rock_band set " . $set;
            }

            DataBaseManager::getInstance()->execute($sql,$data);

            return  (($red !== false) ? $red->id : DataBaseManager::getInstance()->lastInsertId());
        }

        /**
         * supprime le enregistrement qui ne sont pas dans la liste
         * @param $exists
         */
        public function remove_band($exists){

            $sql_del = "delete from rock_band where id not in ( :" . implode(', :', array_keys($exists) ) . ")";

            return DataBaseManager::getInstance()->execute($sql_del,$exists);
        }

        /**
         * verification de l'enregistrement en base
         * @param string $name
         * @return int rock_band_id
         */
        public function get_band($name){

            $sql = "select id from rock_band where `name` = :name  ;";
            $data = ['name' => $name ];

            return  DataBaseManager::getInstance()->result(true , $sql, $data);
        }

        /**
         * list enregistrement
         * @return array rock_band
         */
        public function list_band()
        {
            $sql_list = "select * from rock_band ";

            return DataBaseManager::getInstance()->result(false , $sql_list);
        }
    }
}
