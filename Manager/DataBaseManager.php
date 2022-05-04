<?php namespace Manager {
    use PDO;

    class DataBaseManager
    {
        /**
         * @var
         */
        private static $instance;

        /**
         * @var PDO
         */
        private $dbh;

        /**
         * @return DataBaseManager
         */
        public static function getInstance(){

            if(self::$instance === null ){

                self::$instance = new DataBaseManager();
            }

            return self::$instance ;
        }

        /**
         * connexion à la base
         * DataBaseManager constructor.
         */
        private function __construct(){

            if($this->dbh === null ) {

                try {

                    $dsn = DB_BASE . ':dbname=' . DB_NAME . ';host=' . DB_HOST;
                    $this->dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                } catch (\Exception $e) {
                    die ("Connection failed: " . $e->getMessage());
                }
            }
        }

        /**
         * @param $sql
         * @param array $data
         * @return bool|\PDOStatement
         */
        public function execute($sql,$data = [] ){

            if(!empty($data)) {

                $sth = $this->dbh->prepare($sql);
                $sth->execute($data);

            } else {

                $sth = $this->dbh->query($sql);
                $sth->execute();
            }
            return $sth ;
        }

        /**
         * @param bool $one
         * @param $sql
         * @param array $data
         * @return array|mixed
         */
        public function result( $one = false , $sql ,$data = []){

            $sth = $this->execute($sql ,$data);

            if($sth!== false) {

                if ($one) {

                    return $sth->fetch(PDO::FETCH_OBJ);

                } else {

                    return $sth->fetchAll(PDO::FETCH_OBJ);
                }
            }
        }

        /**
         * @return PDO
         */
        public function getConn()
        {
            return $this->dbh;
        }

        /**
         * @return string
         */
        public function lastInsertId()
        {
            return $this->dbh->lastInsertId();
        }
    }
}


