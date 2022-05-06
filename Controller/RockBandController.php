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
        }

        /**
         * @param $filedata
         * @var RockBandManager $manager
         * @var UploadModel $uploader
         * @var RockBandModel $manager
         */
        public function import()
        {
            /** @var int|SimpleXLSX $xlsx */
            $xlsx = Autoloader::getInstance()->model("Upload")::checking();

            if($xlsx!== false) {
                if (is_int($xlsx)) {

                    $this->err = $xlsx;

                } else {

                    // liste des IDs présent en base et correspondant dans le fichier
                    $exists = [];

                    foreach ($xlsx->rows() as $k => $getData) {

                        if ($k === 0) {

                            continue; // skip first row

                        } else {

                            $data = Autoloader::getInstance()->model("RockBand")::convert_format($getData);

                            if ($data !== false) {

                                $exists["index_" . $k] = $this->manager->save_band($data);

                            } else {

                                $this->failed[] = $k;
                            }

                        }
                    }
                    $this->manager->remove_band($exists);
                }
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
         * @return array
         */
        public function getFailed()
        {
            return $this->failed;
        }
    }
}

