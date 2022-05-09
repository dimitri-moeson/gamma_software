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
        
        
        private $allowed_mime = array ( 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    /**
	     * @var bool
	     */
        private $imported = false ;

        /**
         * @param $index
         * @return mixed
         */
        public function getErr($index) : string
        {
            if(array_key_exists($index,$this->error_model))
                return $this->error_model[$index];
        }

        /**
         * @return array
         */
        private function getAllowedExt():array
        {
            return $this->allowed_ext;
        }

        /**
         * @param $filedata
         * @return bool|int|SimpleXLSX
         */
        public function checking($name = "file")
        {
            if (Autoloader::getInstance()->manager("request")->submitted()) {

                if (Autoloader::getInstance()->manager("request")->uploaded($name)) {

                    $filedata = Autoloader::getInstance()->manager("request")->file($name);

                    $this->imported = true;

                    // import
                    if ($filedata["error"] == 0) {

                        $ext = pathinfo($filedata['name'], PATHINFO_EXTENSION);
	                    $mime = mime_content_type($filedata['name']);

                        if (in_array($ext, $this->getAllowedExt())) {
	
	                        if (in_array($mime, $this->getAllowedMime())) {
	                        	
		                        if ( $filedata[ "size" ] > 0 ) {
			
			                        return $filedata[ "tmp_name" ];
			
		                        } else
			                        return 10;
	                        }else
		                        return 9;
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
        public function isImported() : bool
        {
            return $this->imported;
        }
	
	    /**
	     * @return array
	     */
	    public function getAllowedMime () : array
	    {
		    return $this -> allowed_mime;
	    }
    }
}