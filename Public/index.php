<?php

use Manager\Autoloader;

require_once realpath(__DIR__ . '/../Manager/Autoloader.php');

Autoloader::getInstance()->register();

$controller = Autoloader::getInstance()->manager("request")->get("c", "RockBand");
$action = Autoloader::getInstance()->manager("request")->get("p", "import");
	
Autoloader::getInstance()->execute($controller ,$action);

