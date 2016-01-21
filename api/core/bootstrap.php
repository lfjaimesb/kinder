<?php
define("DS",DIRECTORY_SEPARATOR);
define("SERVER",$_SERVER["SERVER_NAME"]);
define("URLSHORT",dirname($_SERVER["PHP_SELF"]));
define("ROOT",dirname(__DIR__).DS);
define("CORE",ROOT."core".DS);
define("CACHE",ROOT."cache".DS);
define("INTCS",CORE."interfaces".DS);
define("ABS",CORE."abstracts".DS);
define("LIB",CORE."lib".DS);
define("OBJ",CORE."objects".DS);
define("CTRL",ROOT."controls".DS);
define("MODEL",ROOT."models".DS);
define("PAG",ROOT."views".DS);
define("PLUGINS",CORE."plugins".DS);
define("PLUG",ROOT."plugins".DS);
define("SID",session_id());

$path=trim(URLSHORT,"/");

if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]=="on") $path = "https://".SERVER."/".$path;
else $path = "http://".SERVER."/".$path;

$path=trim($path,"/");
define("SITE",$path."/");
unset($path);

require CORE."autoload.php";
require ROOT."config.php";

$Dispatcher = new \Core\Dispatcher();
$Dispatcher->procesar();
?>
