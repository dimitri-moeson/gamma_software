<?php namespace Controller {

    use Manager\{
        Autoloader, RockBandManager, simplexlsx\SimpleXLSX
    };
    use Model\{
        RockBandModel, UploadModel
    };

    class RockBandController
    {
        /**
         * @var RockBandManager
         */
        private $manager;

        /**
         * erreur lor de l'upload du fichier XLSX
         * @var int
         */
        private $err;

        /**
         *  si l'import a été lancé
         * @var bool
         */
        private $imported = false ;

        /**
         * lignes du XLSX non enregistrées => pas de nom de groupe
         * @var array
         */
        private $failed;

        /**
         * RockBandController constructor.
         * @var RockBandManager $manager
         */
        public function __construct()
        {
            $this->manager = Autoloader::getInstance()->manager("RockBand");// $manager ;
            $this->err = 0 ;
            $this->failed = [];
            $this->imported = false ;
        }

        /**
         * @param $filedata
         * @var RockBandManager $manager
         * @var UploadModel $uploader
         * @var RockBandModel $manager
         */
        public function import($filedata)
        {
            $this->imported = true ;

            /** @var int|SimpleXLSX $xlsx */
            $xlsx =  Autoloader::getInstance()->model("Upload")::checking($filedata);

            if(is_int($xlsx)) {

                $this->err = $xlsx;

            } else {

                // liste des IDs présent en base et correspondant dans le fichier
                $exists = [];

                foreach ($xlsx->rows() as $k => $getData) {

                    if ($k === 0) {

                        continue; // skip first row

                    } else {

                        $data = Autoloader::getInstance()->model("RockBand")::convert_format($getData);

                        if ($data !== false ) {

                            $red = $this->manager->get_band($data["name"]);

                            $exists["index_" . $k] = $this->manager->save_band($data, $red);

                        } else {

                            $this->failed[] = $k;
                        }

                    }
                }

                $this->manager->remove_band($exists);
            }
        }

        /**
         * @return int
         */
        public function getErr()
        {
            return $this->err;
        }

        /**
         * @return bool
         */
        public function isImported()
        {
            return $this->imported;
        }

        /**
         * @return array
         */
        public function getFailed()
        {
            return $this->failed;
        }
    }
}

