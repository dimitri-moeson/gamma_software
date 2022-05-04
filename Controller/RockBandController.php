<?php namespace Controller {

    use Manager\simplexlsx\SimpleXLSX;
    use Model\RockBandModel;
    use Manager\RockBandManager;
    use Model\UploadModel;

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

        public function __construct(RockBandManager $manager)
        {
            $this->manager = $manager ;
            $this->err = 0 ;
            $this->failed = [];
            $this->imported = false ;
        }

        public function import($filedata)
        {
            $this->imported = true ;

            // import
            if ($filedata["error"] == 0) {

                $fname = $filedata['name'];
                $ext = pathinfo($fname, PATHINFO_EXTENSION);

                if (in_array($ext, UploadModel::getAllowedExt())) {

                    $filename = $filedata["tmp_name"];

                    if ($xlsx = SimpleXLSX::parse($filename)) {

                        if ($filedata["size"] > 0) {

                            // liste des IDs présent en base et correspondant dans le fichier
                            $exists = [];

                            foreach ($xlsx->rows() as $k => $getData) {

                                if ($k == 0) {

                                    continue; // skip first row

                                } else {

                                    $data = RockBandModel::format_data($getData);

                                    if (RockBandModel::confirm_line($data)) {

                                        $red = $this->manager->get_band($data["name"]);

                                        $exists["index_" . $k] = $this->manager->save_band($data, $red);

                                    } else {

                                        $this->failed[] = $k;
                                    }
                                }
                            }

                            $this->manager->remove_band($exists);
                        }
                    } else {

                        $this->err = 9;
                    }

                } else {

                    $this->err = 5;
                }

            } else {

                $this->err = $filedata["error"] ;
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

