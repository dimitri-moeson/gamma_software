<?php namespace View {

    use Controller\RockBandController;
    use Manager\{
        Autoloader, RockBandManager
    };
    use Model\{
        RockBandModel, UploadModel
    };

    /**
     * Class RockBandView
     * @package View
     */
    class RockBandView {

        /**
         * @return string
         */
        protected static function header_html(){

            header('Content-Type: text/html; charset=utf-8');
            return
                '<!--DOCTYPE html-->'
                .self::indent(0).'<html lang="fr">'
                .self::indent(1).'<head>'
                .self::indent(2).'<title>Import</title>'
                .self::indent(2).'<meta http-equiv="Content-type" content="text/html; charset=utf-8" />'
                .self::indent(1).'</title>'
                .self::indent(1).'<body>'
                .self::indent(2).'<div id="wrap">'
                .self::indent(3).'<div class="container">'
                .self::indent(0);
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
        public static function body_html(){

            $content  = self::header_html();
            $content .= self::form_import();
            $content .= self::list_import();
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
            for($i = 0 ; $i < $repeat ; $i++) $html .= "\t" ;
            return $html ;
        }

        /**
         * @var RockBandController $controller
         * @var UploadModel $uploader
         * @return string
         */
        private static function form_import(){

            $html = "";

            $controller = Autoloader::getInstance()->controller("RockBand");

            if(Autoloader::getInstance()->model("upload")::isImported()) {

                $html .= self::indent(3) . "<b>" . Autoloader::getInstance()->model("upload")::getErr($controller->getErr()) . "</b><br/>";

                if(!empty($controller->getFailed()))
                    $html .= self::indent(3) . "<b>les lignes suivantes n'ont pas pu etre importées : [" . implode( "]-[", $controller->getFailed()) . "]</b><br/>";
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
                .self::indent(3).'</div>'
                .self::indent(0);

            return $html ;
        }

        /**
         * @var RockBandManager $manager
         * @var RockBandModel $model
         * @return string
         */
        private static function list_import(){

            $html =
                 self::indent(3).'<table border="1">'
                .self::indent(4).'<tbody>'
                .self::indent(0);

            $manager = Autoloader::getInstance()->manager("RockBand");
            $model = Autoloader::getInstance()->model("RockBand");

            foreach( $manager->list_band() as $item) {

                $html .=
                     self::indent(5).'<tr>'
                    .self::indent(6)
                        .'<td>'.$item->id.'</td>'
                        .'<td>'.$item->name.'</td>'
                        .'<td>'.$item->country.'</td>'
                        .'<td>'.$item->city.'</td>'
                        .'<td>'.$item->start_year.'</td>'
                        .'<td>'.$model::nullable($item->end_year).'</td>'
                        .'<td>'.$item->founder.'</td>'
                        .'<td>'.$model::nullable($item->member_count).'</td>'
                        .'<td>'.$item->music_type.'</td>'
                    .self::indent(6).'<td>'.$item->presentation.'</td>'
                    .self::indent(5).'</tr>'
                    .self::indent(0);

            }

            $html .=
                 self::indent(4).'</tbody>'
                .self::indent(0)
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
                .self::indent(0)
                .self::indent(4).'</table>';

            return $html ;
        }
    }
}