<?php

use Manager\Autoloader;

require_once realpath(__DIR__ . '/../Manager/Autoloader.php');

		Autoloader::getInstance()->register();

$p =    Autoloader::getInstance()->manager("request")->get("p", "import");

		Autoloader::getInstance()->controller("RockBand")->$p();

print   Autoloader::getInstance()->view("RockBand")->$p();