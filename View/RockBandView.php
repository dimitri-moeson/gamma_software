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
                .self::indent(0).'<html lang="fr">'
                .self::indent(1).'<head>'
                .self::indent(2).'<title>Import</title>'
                .self::indent(1).'</title>'
                .self::indent(1).'<body>'
                .self::indent(2).'<div id="wrap">'
                .self::indent(3).'<div class="container">';
        }

        /**
         * @return string
         */
        protected static function footer_html(){

            return
                 self::indent(3).'</div>'
                .self::indent(2).'</div>'
                .self::indent(1).'</body>'
                .self::indent(0).'</html>';
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
         * @param $repeat
         * @return string
         */
        private static function indent($repeat)
        {
            $html = "\r\n" ;

            for($i = 0 ; $i < $repeat ; $i++){

                $html .= "\t" ;

            }

            return $html ;
        }

        /**
         * formulaire de chargement
         * @return string
         */
        private static function form_import(RockBandController $controller){

            $html = "";

            if($controller->isImported()) {

                $html .= self::indent(3) . "<b>" . UploadModel::getErr($controller->getErr()) . "</b><br/>";

                if(!empty($controller->getFailed())){

                    $html .= self::indent(3) . "<b>les lignes suivantes n'ont pas pu etre importées : [" . implode( "]-[", $controller->getFailed()) . "]</b><br/>";

                }
            }
            $html .=
                 self::indent(3).'<div class="row">'
                .self::indent(4).'<form method="post" enctype="multipart/form-data">'
                .self::indent(5).'<div>'
                .self::indent(6).'<label for="file">Sélectionner le fichier à envoyer</label>'
                .self::indent(6).'<input type="file" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">'
                .self::indent(5).'</div>'
                .self::indent(5).'<div>'
                .self::indent(6).'<input type="submit" name="send" value="Envoyer" />'
                .self::indent(5).'</div>'
                .self::indent(4).'</form>'
                .self::indent(3).'</div>';

            return $html ;
        }

        /**
         * @param $manager
         * @return string
         */
        private static function list_import(RockBandManager $manager){

            $html =
                 self::indent(3).'<table border="1">'
                .self::indent(4).'<tbody>';

            foreach( $manager->list_band() as $item) {

                $html .=
                     self::indent(5).'<tr>'
                    .self::indent(6).'<td>'.$item->id.'</td>'
                    .self::indent(6).'<td>'.$item->name.'</td>'
                    .self::indent(6).'<td>'.$item->country.'</td>'
                    .self::indent(6).'<td>'.$item->city.'</td>'
                    .self::indent(6).'<td>'.$item->start_year.'</td>'
                    .self::indent(6).'<td>'.RockBandModel::nullable($item->end_year).'</td>'
                    .self::indent(6).'<td>'.$item->founder.'</td>'
                    .self::indent(6).'<td>'.RockBandModel::nullable($item->member_count).'</td>'
                    .self::indent(6).'<td>'.$item->music_type.'</td>'
                    .self::indent(6).'<td>'.$item->presentation.'</td>'
                    .self::indent(5).'</tr>';

            }

            $html .=
                 self::indent(4).'</tbody>'
                .self::indent(4).'<thead>'
                .self::indent(5).'<tr>'
                .self::indent(6).'<th>ID</th>'
                .self::indent(6).'<th>Nom du groupe</th>'
                .self::indent(6).'<th>Origine</th>'
                .self::indent(6).'<th>Ville</th>'
                .self::indent(6).'<th>Année de début</th>'
                .self::indent(6).'<th>Année de sépartion</th>'
                .self::indent(6).'<th>Fondateurs</th>'
                .self::indent(6).'<th>Membres</th>'
                .self::indent(6).'<th>Courant musical</th>'
                .self::indent(6).'<th>Présentation </th>'
                .self::indent(5).'</tr>'
                .self::indent(4).'</thead>'
                .self::indent(4).'</table>';

            return $html ;
        }
    }
}