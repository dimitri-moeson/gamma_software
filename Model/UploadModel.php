<?php namespace Model {

    use Manager\Autoloader;
    use Manager\simplexlsx\SimpleXLSX;

    /**
     * Class UploadModel
     * @package Model
     */
    class UploadModel
    {
        /**
         * @var array
         */
        private $error_model = array(

            0 => 'le téléchargement est correct',
            1 => 'La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini',
            2 => 'La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML',
            3 => 'Le fichier n\'a été que partiellement téléchargé',
            4 => 'Aucun fichier n\'a été téléchargé',

            6 => 'Un dossier temporaire est manquant',
            7 => 'Échec de l\'écriture du fichier sur le disque.',
            8 => 'Une extension PHP a arrêté l\'envoi de fichier.',

            5 => "le fichier n'est pas en XLSX.",

            9 => "le fichier XLSX est invalide.",

            10 => "le fichier est vide."
        );

        /**
         * @var array
         */
        private $allowed_ext = array('xlsx');
        
	    /**
	     * @var bool
	     */
        private $imported = false ;

        /**
         * @param $index
         * @return mixed
         */
        public function getErr($index)
        {
            if(array_key_exists($index,$this->error_model))
                return $this->error_model[$index];
        }

        /**
         * @return array
         */
        private function getAllowedExt()
        {
            return $this->allowed_ext;
        }

        /**
         * @param $filedata
         * @return bool|int|SimpleXLSX
         */
        public function checking()
        {
            if (Autoloader::getInstance()->manager("request")->submitted()) {

                if (Autoloader::getInstance()->manager("request")->uploaded("file")) {

                    $filedata = Autoloader::getInstance()->manager("request")->file("file");

                    $this->imported = true;

                    // import
                    if ($filedata["error"] == 0) {

                        $fname = $filedata['name'];
                        $ext = pathinfo($fname, PATHINFO_EXTENSION);

                        if (in_array($ext, $this->getAllowedExt())) {

                            if ($filedata["size"] > 0) {

                                $filename = $filedata["tmp_name"];

                                $xlsx = SimpleXLSX::parse($filename);

                                if ($xlsx !== false)
                                    return $xlsx;
                                else
                                    return 9;
                            } else
                                return 10;
                        } else
                            return 5;
                    } else
                        return $filedata["error"];
                }
            }
            return false;
        }

        /**
         * @return bool
         */
        public function isImported()
        {
            return $this->imported;
        }
    }
}