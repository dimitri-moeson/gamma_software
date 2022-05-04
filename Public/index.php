<?php

use Controller\RockBandController;
use Manager\Autoloader;
use Manager\RockBandManager;
use View\RockBandView;

require_once realpath(__DIR__ . '/../config/config.php');
require_once realpath(__DIR__ . '/../Manager/Autoloader.php');

Autoloader::register();

$manager = new RockBandManager();
$controller = new RockBandController($manager);

if (getenv('REQUEST_METHOD') === "POST" && isset($_POST['send'])) {

    if(isset($_FILES["file"])) {

        $controller->import($_FILES["file"]);
    }
}

print RockBandView::body_html($controller,$manager);
