<?php namespace Manager {

    use PDO;

    class DataBaseManager
    {
        /**
         * @var DataBaseManager
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

                    $conf = Autoloader::getInstance()->manager("config");

                    $dsn = $conf->param('db_serv') . ':'
                        .'dbname='  . $conf->param('db_name') .';'
                        .'host='    . $conf->param('db_host') .';' ;

                    $arr_conf = array(

                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,

                    );

                    $trace = $conf->exists('db_trac')  ;
                    $charset = $conf->exists('db_char')  ;

                    if($trace !== false )
                        $arr_conf[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION  ;
                    

                    if($charset !== false ) {

                        $sql_charset =  'SET NAMES ' . $conf->option('db_char') ;

                        if($conf->option('db_coll') != false)
                            $sql_charset .= ' COLLATE '.$conf->option('db_coll') ;
                        
                        $sql_charset .= ';' ;
                        
                        $dsn .= 'charset=' . $conf->option('db_char') . ';';
                        $arr_conf[PDO::MYSQL_ATTR_INIT_COMMAND] = $sql_charset ;
                    }

                    $this->dbh = new PDO($dsn,  $conf->param('db_user'), $conf->param('db_pass'), $arr_conf );

                    if($charset !== false )
                        $this->dbh->exec( $sql_charset );

                    if($trace !== false )
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

                if ($one)
                    return $sth->fetch(PDO::FETCH_OBJ);
                else
                    return $sth->fetchAll(PDO::FETCH_OBJ);
            }
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


