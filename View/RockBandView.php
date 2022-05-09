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
		    //$content .= print_r ($this,true);
		    $content .= $this->footer_html();
		
		    return trim($content) ;
		
	    }
	
	    public function edit()
	    {
		    $content  = $this->header_html();
		    $content .= $this->form_edit();
		    $content .= $this->footer_html();
		
		    return trim($content) ;
		
	    }
	
	    public function delete()
	    {
		    $content  = $this->header_html();
		    $content .= $this->form_delete();
		    $content .= $this->footer_html();
		
		    return trim($content) ;
		
	    }
	
	    /**
	     * @return string
	     */
	    private function form_delete()
	    {
		    $item = $this->controller->band ;
		
		    $model = Autoloader::getInstance()->model("RockBand");
		
		    $html =
			
			    ''
			
			    .$this->indent(3).'<div class="row">'
			    .$this->indent(4).'<form method="post">'
			    .$this->indent(5).'<input type="hidden" name="id" value="'.$item->id.'"/>'
			    .$this->indent(5).'<input type="hidden" name="country" value="'.$item->country_id.'"/>'
			    .$this->indent(5).'<input type="hidden" name="city" value="'.$item->city_id.'"/>'
			    .$this->indent(5).'<div>'
			    .$this->indent(6).'<table border="1">'
			    .$this->indent(7).'<tbody>'
			    .$this->indent(0)
			
			    .$this->indent(8).'<tr>'.'<th>Nom du groupe</th>'
			    .$this->indent(9).'<td>'.$item->name.'</td>'
			    .'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Année de début</th>'
			    .$this->indent(9).'<td>'.$model::nullable($item->start_year).'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Origine</th>'
			    .$this->indent(9).'<td>'.$item->country.'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Ville</th>'
			    .$this->indent(9).'<td>'.$item->city.'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Année de séparation</th>'
			    .$this->indent(9).'<td>'.$model::nullable($item->end_year).'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Fondateurs</th>'
			    .$this->indent(9).'<td>'.$item->founder.'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Membres</th>'
			    .$this->indent(9).'<td>'.$model::nullable($item->member_count).'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>'.'<th>Courant musical</th>'
			    .$this->indent(9).'<td>'.$item->music_type.'</td>'.'</tr>'
			
			    .$this->indent(8).'<tr>' .'<th>Présentation </th>'
			    .$this->indent(9).'<td>'.$item->presentation.'</td>'
			    .$this->indent(8).'</tr>'
			    .$this->indent(0);
		
		    $html .=
			
			    $this->indent(7).'</tbody>'
			    .$this->indent(6).'</table>'
			    .$this->indent(5).'</div>'
			    .$this->indent(5).'<div>'
			    .$this->indent(6).'<a href="?p=import">retour</a>'
			    .$this->indent(6).'<input type="submit" name="remove" value="supprimer" />'
			    .$this->indent(5).'</div>'
			    .$this->indent(4).'</form>'
			    .$this->indent(3).'</div>'
			    .$this->indent(0);
		
		    return $html;
		
	    }
	
	
	    /**
	     * @return string
	     */
	    private function form_edit()
	    {
		    $item = $this->controller->band ;
		
		    $model = Autoloader::getInstance()->model("RockBand");
		
		    $html =
			
			    '<a href="?p=import">retour</a>'
			
			    .$this->indent(3).'<div class="row">'
			    .$this->indent(4).'<form method="post">'
			    .$this->indent(5).'<input type="hidden" name="id" value="'.$item->id.'"/>'
			    .$this->indent(5).'<input type="hidden" name="country" value="'.$item->country_id.'"/>'
			    .$this->indent(5).'<input type="hidden" name="city" value="'.$item->city_id.'"/>'
			    .$this->indent(5).'<div>'
			    .$this->indent(6).'<table border="1">'
			    .$this->indent(7).'<tbody>'
			    .$this->indent(0)
			
			    .$this->indent(8).'<tr>'.'<th>Nom du groupe</th>'
			    .$this->indent(9).'<td><input name="name" value="'.$item->name.'"/></td>'
			    .'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Année de début</th>'
			    .$this->indent(9).'<td><input name="start_year" value="'.$model::nullable($item->start_year).'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Origine</th>'
			    .$this->indent(9).'<td><input disabled value="'.$item->country.'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Ville</th>'
			    .$this->indent(9).'<td><input disabled value="'.$item->city.'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Année de séparation</th>'
			    .$this->indent(9).'<td><input name="end_year" value="'.$model::nullable($item->end_year).'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Fondateurs</th>'
			    .$this->indent(9).'<td><input name="founder" value="'.$item->founder.'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Membres</th>'
			    .$this->indent(9).'<td><input name="member_count" value="'.$model::nullable($item->member_count).'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>'.'<th>Courant musical</th>'
			    .$this->indent(9).'<td><input name="music_type" value="'.$item->music_type.'"/></td>'.'</tr>'
			    
			    .$this->indent(8).'<tr>' .'<th>Présentation </th>'
			    .$this->indent(9).'<td><textarea name="presentation">'.$item->presentation.'</textarea></td>'
			    .$this->indent(8).'</tr>'
			    .$this->indent(0);
		
		    $html .=
			
			    $this->indent(7).'</tbody>'
			    .$this->indent(6).'</table>'
			    .$this->indent(5).'</div>'
			    .$this->indent(5).'<div>'
			    .$this->indent(6).'<input type="submit" name="send" value="Envoyer" />'
			    .$this->indent(5).'</div>'
			    .$this->indent(4).'</form>'
			    .$this->indent(3).'</div>'
			    .$this->indent(0);
		
		    return $html;
		
	    }
	
	    /**
	     * @return string
	     */
	    private function detail()
	    {
		    $item = $this->controller->band ;
		
		    $model = Autoloader::getInstance()->model("RockBand");
		    
		    $html =
			    
			    '<a href="?p=import">retour</a>'
			    
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
                        .'<td><a href="?p=edit&id='.$item->id.'">Edit</a></td>'
                        .'<td><form method="post" action="?p=delete">'
                            .$this->indent(5).'<input type="hidden" name="id" value="'.$item->id.'"/>'
                            .$this->indent(6).'<input type="submit" name="suppr" value="Supprimer" />'
                            .'</form></td>'
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
                 .'<th></th>'
                .$this->indent(5).'</tr>'
                .$this->indent(4).'</thead>'
                .$this->indent(0)
                .$this->indent(4).'</table>';

            return $html ;
        }
    }
}