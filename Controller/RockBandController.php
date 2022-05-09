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
	     * @var
	     */
	    public $band;
	
	    /**
         * RockBandController constructor.
         * @var RockBandManager $manager
         */
        public function __construct()
        {
            $this->err = 0 ;
            $this->failed = [];
        }
        
	    public function edit()
	    {
		    $id = Autoloader::getInstance()->manager("request")->get("id");
		    
		    if (Autoloader::getInstance()->manager("request")->submitted()) {
			
			    $getData = Autoloader::getInstance()->manager("request")->content ();
			    
			    $data = Autoloader::getInstance()->model("RockBand")->format_post($getData);
		    	
			    Autoloader::getInstance()->manager("RockBand")->save_edit($data, $id);
		    }
		    
		    $this->band = Autoloader::getInstance()->manager("RockBand")->get_rock($id);
	    }
	
	    public function delete()
	    {
		    $id = Autoloader::getInstance()->manager("request")->get("id");
		
		    if (Autoloader::getInstance()->manager("request")->submitted()) {
			
		    	if(Autoloader::getInstance()->manager("request")->exists("remove")){
				
				    Autoloader::getInstance()->manager("RockBand")->remove_rock($id);
				    
			    }
			    
			    if(Autoloader::getInstance()->manager("request")->exists("suppr")){
				    
		    		$this->band = Autoloader::getInstance()->manager("RockBand")->get_rock($id);
				
			    }
		    }
			   
	    }
	    
	    public function details()
	    {
		    $id = Autoloader::getInstance()->manager("request")->get("id");
		    
		    $this->band = Autoloader::getInstance()->manager("RockBand")->get_rock($id);
        }

        /**
         * @param $filedata
         * @var RockBandManager $manager
         * @var UploadModel $uploader
         * @var RockBandModel $manager
         */
        public function import()
        {
	        /**
	         * @var string $filename
	         */
	        $filename = Autoloader::getInstance()->model("Upload")->checking("file");
	
	        /** @var int|SimpleXLSX $xlsx */
	        $xlsx = SimpleXLSX::parse($filename);
	
	        /**if ($xlsx !== false)
		        return $xlsx;
	        else
		        return 9;**/
            
            if($xlsx!== false) {
                if (is_int($xlsx))
                    $this->err = $xlsx;
                else {
                    
                    $exists = []; // liste des IDs présent en base et correspondant dans le fichier

                    foreach ($xlsx->rows() as $k => $getData) {

                        if ($k === 0)
                            continue; // skip first row
                        else {

                            $data = Autoloader::getInstance()->model("RockBand")->convert_format($getData);

                            if ($data !== false)
                                $exists["index_" . $k] = Autoloader::getInstance()->manager("RockBand")->save_band($data);
                            else
                                $this->failed[] = $k;
                        }
                    }
	                Autoloader::getInstance()->manager("RockBand")->remove_band($exists);
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

