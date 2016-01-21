<?php
namespace Core;
use Core\Config;
use Control;

class Dispatcher{
	public function __construct(){
		$this->getUrl();
	}

	function procesar(){
		$c = "Control\\". Config::Reader("control");

		if(class_exists($c, true)){
			$funcion = Config::Reader("function");
			$control = new $c();
			$control->Run($funcion,explode("/", Config::Reader("parametros")));
		}else{
			echo json_encode(["data"=>"Recurso no disponible"]);
		}
	}

	private function getUrl(){
		$url = isset($_GET["url"])?$_GET["url"]:"";
		unset($_GET["url"]);

		$url=explode("/",trim($url,"/"),3);
		if(count($url)>0){
			$url[0] = str_replace(" ","",ucwords($url[0]));
			Config::Write("control",($url[0]!=""?$url[0]:"Index")."Control");
			Config::Write("function",isset($url[1])?str_replace(" ","",$url[1]):"index");
			Config::Write("parametros",isset($url[2])?$url[2]:"");
		}
	}
}

?>
