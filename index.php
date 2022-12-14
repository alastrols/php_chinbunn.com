<?php
session_start();
$bootstrap = [
  "config_folder"=> __DIR__."/config",
  "autoload"=> __DIR__."/vendor/autoload.php"
  // "config"=> "../config.php",
  // "config"=> "../config.php",
  // "config"=> "../config.php",
  // "config"=> "../config.php",
];

date_default_timezone_set("Asia/Bangkok");

require($bootstrap["autoload"]);

$app = new \Main\Main($bootstrap["config_folder"]);
$app->run();
