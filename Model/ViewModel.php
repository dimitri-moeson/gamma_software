<?php
	/**
	 * Created by PhpStorm.
	 * User: admin
	 * Date: 06/05/2022
	 * Time: 20:07
	 */
	
	namespace Model;
	
	
	class ViewModel
	{
		/**
		 * @param $repeat
		 * @return string
		 */
		protected function indent($repeat)
		{
			$html = "\r\n" ;
			for($i = 0 ; $i < $repeat ; $i++) $html .= "\t" ;
			return $html ;
		}
		
		/**
		 * @return string
		 */
		protected function header_html(){
			
			header('Content-Type: text/html; charset=utf-8');
			return
				'<!--DOCTYPE html-->'
				.$this->indent(0).'<html lang="fr">'
				.$this->indent(1).'<head>'
				.$this->indent(2).'<title>Import</title>'
				.$this->indent(2).'<meta http-equiv="Content-type" content="text/html; charset=utf-8" />'
				.$this->indent(1).'</title>'
				.$this->indent(1).'<body>'
				.$this->indent(2).'<div id="wrap">'
				.$this->indent(3).'<div class="container">'
				.$this->indent(0);
		}
		
		
		/**
		 * @return string
		 */
		protected function footer_html(){
			
			return
				 $this->indent(3).'</div>'
				.$this->indent(2).'</div>'
				.$this->indent(1).'</body>'
				.$this->indent(0).'</html>';
		}
	}