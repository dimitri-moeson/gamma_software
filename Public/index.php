<?php

use Manager\Autoloader;

require_once realpath(__DIR__ . '/../Manager/Autoloader.php');

Autoloader::getInstance()->register();

Autoloader::getInstance()->controller("RockBand")->import();

print Autoloader::getInstance()->view("RockBand")::body_html();