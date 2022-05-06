<?php namespace View {

    use Controller\RockBandController;
    use Manager\{
        Autoloader, RockBandManager
    };
	use Model\{
		RockBandModel , UploadModel , ViewModel
	};

    /**
     * Class RockBandView
     * @package View
     */
    class RockBandView extends ViewModel {
    	
        /**
         * @param $manager
         * @return string
         */
        public function import(){

            $content  = $this->header_html();
            $content .= $this->form_import();
            $content .= $this->list_import();
            $content .= $this->footer_html();

            return trim($content) ;

        }
	
	    /**
	     * @return string
	     */
	    public function details(){
		
		    $content  = $this->header_html();
		    $content .= $this->detail();
		    $content .= $this->footer_html();
		
		    return trim($content) ;
		
	    }
	
	    /**
	     * @return string
	     */
	    private function detail()
	    {
		    $id = Autoloader::getInstance()->manager("request")->get("id");
		
		    $item = Autoloader::getInstance()->manager("RockBand")->get_rock($id);
		
		    $model = Autoloader::getInstance()->model("RockBand");
		    
		    $html ='<a href="?p=import">retour</a>'
			    .$this->indent(3).'<table border="1">'
			    .$this->indent(4).'<tbody>'
			    .$this->indent(0)
		
		        .$this->indent(5).'<tr>' .'<th>Nom du groupe</th>'       .'<td>'.$item->name.'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Année de début</th>'      .'<td>'.$item->start_year.'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Origine</th>'             .'<td>'.$item->country.'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Ville</th>'               .'<td>'.$item->city.'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Année de séparation</th>' .'<td>'.$model::nullable($item->end_year).'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Fondateurs</th>'          .'<td>'.$item->founder.'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Membres</th>'             .'<td>'.$model::nullable($item->member_count).'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Courant musical</th>'     .'<td>'.$item->music_type.'</td>'.'</tr>'
			    .$this->indent(5).'<tr>' .'<th>Présentation </th>'
			            .$this->indent(6).'<td>'.$item->presentation.'</td>'
		        .$this->indent(5).'</tr>'
		        .$this->indent(0);
		 		    
$html .=
	$this->indent(4).'</tbody>'
	.$this->indent(4).'</table>';

			return $html;
		   
	    }
	    
        /**
         * @var RockBandController $controller
         * @var UploadModel $uploader
         * @return string
         */
        private function form_import(){

            $html = "";

            $controller = Autoloader::getInstance()->controller("RockBand");

            if(Autoloader::getInstance()->model("upload")->isImported()) {

                $html .= $this->indent(3) . "<b>" . Autoloader::getInstance()->model("upload")->getErr($controller->getErr()) . "</b><br/>";

                if(!empty($controller->getFailed()))
                    $html .= $this->indent(3) . "<b>les lignes suivantes n'ont pas pu etre importées : [" . implode( "]-[", $controller->getFailed()) . "]</b><br/>";
            }
            $html .=
                 $this->indent(3).'<div class="row">'
                .$this->indent(4).'<form method="post" enctype="multipart/form-data">'
                .$this->indent(5).'<div>'
                .$this->indent(6).'<label for="file">Sélectionner le fichier à envoyer</label>'
                .$this->indent(6).'<input type="file" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">'
                .$this->indent(5).'</div>'
                .$this->indent(5).'<div>'
                .$this->indent(6).'<input type="submit" name="send" value="Envoyer" />'
                .$this->indent(5).'</div>'
                .$this->indent(4).'</form>'
                .$this->indent(3).'</div>'
                .$this->indent(0);

            return $html ;
        }

        /**
         * @var RockBandManager $manager
         * @var RockBandModel $model
         * @return string
         */
        private function list_import(){

            $html =
                 $this->indent(3).'<table border="1">'
                .$this->indent(4).'<tbody>'
                .$this->indent(0);

            $manager = Autoloader::getInstance()->manager("RockBand");

            foreach( $manager->list_band() as $item) {

                $html .=
                     $this->indent(5).'<tr>'
                    .$this->indent(6)
                        .'<td>'.$item->name.'</td>'
                        .'<td>'.$item->start_year.'</td>'
                        .'<td><a href="?p=details&id='.$item->id.'">Details</a></td>'
                    .$this->indent(5).'</tr>'
                    .$this->indent(0);

            }

            $html .=
                 $this->indent(4).'</tbody>'
                .$this->indent(0)
                .$this->indent(4).'<thead>'
                .$this->indent(5).'<tr>'
                .$this->indent(6)
                    .'<th>Nom du groupe</th>'
                    .'<th>Année de début</th>'
                    .'<th></th>'
                .$this->indent(5).'</tr>'
                .$this->indent(4).'</thead>'
                .$this->indent(0)
                .$this->indent(4).'</table>';

            return $html ;
        }
    }
}