<?php
use Core\Config;

Config::Write("CACHE",false);

Config::Write("BD_HOST","localhost");
Config::Write("BD_NAME","erp");
Config::Write("BD_USER","root");
Config::Write("BD_PASS","bm9ybWFu");
Config::Write("BD_DRIVE","mysql");

Config::Write('control',"indexControl");
Config::Write('function',"index");
Config::Write('parametros','');

/*****  Selección de plantillas *****/
Config::Write("FPLANTILLA","boot");
Config::Write("Admin","admin");
Config::Write("Page",array("panel"=>"cliente"));

Config::Write("IMG",array("images", "banners"));
Config::Write("SESSION","MANAGER");

Config::Write("Formatos",array("image/png", "image/pjpeg", "image/jpg", "image/jpeg", "image/gif"));
Config::Write("SizeImage",array("Logo"=>2));
Config::Write("DimImage",array("Logo"=>array(250,250)));

Config::Write("SALT", "secret");
?>
