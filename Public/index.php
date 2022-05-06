<?php

use Controller\RockBandController;
use Manager\Autoloader;
use Manager\RockBandManager;
use View\RockBandView;

require_once realpath(__DIR__ . '/../Manager/Autoloader.php');

Autoloader::getInstance()->register();

$manager = Autoloader::getInstance()->manager("RockBand");//new RockBandManager();
$controller = Autoloader::getInstance()->controller("RockBand");// new RockBandController($manager);
$view = Autoloader::getInstance()->view("RockBand");

if (getenv('REQUEST_METHOD') === "POST" && isset($_POST['send'])) {

    if(isset($_FILES["file"])) {

        $controller->import($_FILES["file"]);
    }
}

print $view::body_html();

var_dump(ini_get_all(null, true ));
