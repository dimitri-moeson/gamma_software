<?php namespace View {

    use Controller\RockBandController;
    use Manager\RockBandManager;
    use Model\RockBandModel;
    use Model\UploadModel;

    /**
     * Class RockBandView
     * @package View
     */
    class RockBandView {

        /**
         * @return string
         */
        protected static function header_html(){

            return
                '<!--DOCTYPE html-->'
                ."\r\n".'<html lang="fr">'
                ."\r\n"."\t".'<head>'
                ."\r\n"."\t".'</head>'
                ."\r\n"."\t".'<body>'
                ."\r\n"."\t\t".'<div id="wrap">'
                ."\r\n"."\t\t".'<div class="container">';
        }

        /**
         * @return string
         */
        protected static function footer_html(){

            return
                 "\r\n"."\t\t".'</div>'
                ."\r\n"."\t\t".'</div>'
                ."\r\n"."\t".'</body>'
                ."\r\n".'</html>';
        }

        /**
         * @param $manager
         * @return string
         */
        public static function body_html($controller,$manager){

            $content = self::header_html();
            $content .= self::form_import($controller);
            $content .= self::list_import($manager);
            $content .= self::footer_html();

            return trim($content) ;

        }

        /**
         * formulaire de chargement
         * @return string
         */
        private static function form_import(RockBandController $controller){

            $html = "";

            if($controller->isImported()) {

                $html .= "\r\n" . "\t\t\t" . "<b>" . UploadModel::getErr($controller->getErr()) . "</b><br/>";

                if(!empty($controller->getFailed())){

                    $html .= "\r\n" . "\t\t\t" . "<b>les lignes suivantes n'ont pas pu etre importées : [" . implode( "]-[", $controller->getFailed()) . "]</b><br/>";

                }
            }
            $html .=
                 "\r\n"."\t\t\t".'<div class="row">'
                ."\r\n"."\t\t\t".'<form method="post" enctype="multipart/form-data">'
                ."\r\n"."\t\t\t".'<div>'
                ."\r\n"."\t\t\t".'<label for="file">Sélectionner le fichier à envoyer</label>'
                ."\r\n"."\t\t\t".'<input type="file" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">'
                ."\r\n"."\t\t\t".'</div>'
                ."\r\n"."\t\t\t".'<div>'
                ."\r\n"."\t\t\t".'<input type="submit" name="send" value="Envoyer" />'
                ."\r\n"."\t\t\t".'</div>'
                ."\r\n"."\t\t\t".'</form>'
                ."\r\n"."\t\t\t".'</div>';

            return $html ;
        }

        /**
         * @param $manager
         * @return string
         */
        private static function list_import(RockBandManager $manager){

            $html =
                 "\r\n"."\t\t\t".'<table border="1">'
                ."\r\n"."\t\t\t".'<tbody>';

            foreach( $manager->list_band() as $item) {

                $html .=
                     "\r\n"."\t\t\t".'<tr>'
                    ."\r\n"."\t\t\t".'<td>'.$item->id.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->name.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->country.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->city.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->start_year.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.RockBandModel::nullable($item->end_year).'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->founder.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.RockBandModel::nullable($item->member_count).'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->music_type.'</td>'
                    ."\r\n"."\t\t\t".'<td>'.$item->presentation.'</td>'
                    ."\r\n"."\t\t\t".'</tr>';

            }

            $html .=
                 "\r\n"."\t\t\t".'</tbody>'
                ."\r\n"."\t\t\t".'<thead>'
                ."\r\n"."\t\t\t".'<tr>'
                ."\r\n"."\t\t\t".'<th>ID</th>'
                ."\r\n"."\t\t\t".'<th>Nom du groupe</th>'
                ."\r\n"."\t\t\t".'<th>Origine</th>'
                ."\r\n"."\t\t\t".'<th>Ville</th>'
                ."\r\n"."\t\t\t".'<th>Année de début</th>'
                ."\r\n"."\t\t\t".'<th>Année de sépartion</th>'
                ."\r\n"."\t\t\t".'<th>Fondateurs</th>'
                ."\r\n"."\t\t\t".'<th>Membres</th>'
                ."\r\n"."\t\t\t".'<th>Courant musical</th>'
                ."\r\n"."\t\t\t".'<th>Présentation </th>'
                ."\r\n"."\t\t\t".'</tr>'
                ."\r\n"."\t\t\t".'</thead>'
                ."\r\n"."\t\t\t".'</table>';

            return $html ;
        }
    }
}