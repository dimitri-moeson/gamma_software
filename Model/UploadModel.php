<?php namespace Model {

    /**
     * Class UploadModel
     * @package Model
     */
    class UploadModel
    {
        /**
         * @var array
         */
        private static $error_model = array(

            0 => 'le téléchargement est correct',
            1 => 'La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini',
            2 => 'La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML',
            3 => 'Le fichier n\'a été que partiellement téléchargé',
            4 => 'Aucun fichier n\'a été téléchargé',

            6 => 'Un dossier temporaire est manquant',
            7 => 'Échec de l\'écriture du fichier sur le disque.',
            8 => 'Une extension PHP a arrêté l\'envoi de fichier.',

            5 => "le fichier n'est pas en XLSX.",

            9 => "le fichier XLSX est invalide."
        );

        /**
         * @var array
         */
        private static $allowed_ext = array('xlsx');

        /**
         * @param $index
         * @return mixed
         */
        public static function getErr($index)
        {
            if(array_key_exists($index,self::$error_model))
                return self::$error_model[$index];
        }

        /**
         * @return array
         */
        public static function getAllowedExt()
        {
            return self::$allowed_ext;
        }
    }
}