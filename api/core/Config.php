<?php
namespace Core;

class Config {
	static $objects = array("Errors"=>array());
	private static $Instance=null;

	public static function Singleton(){
		if(self::$Instance==null){
			$c = __CLASS__;
			self::$Instance=new $c();
		}

		return self::$Instance;
	}

	public static function Verify($cve) {
		return isset(self::$objects[$cve]);
	}

	public static function Reader($cve) {
		if (isset(self::$objects[$cve])) {
			return self::$objects[$cve];
		}

		return null;
	}

	public static function Write($cve, $val, $bdr=false){
		if(!$bdr) self::$objects[$cve]=$val;
		else{
			if(self::Verify($cve)) self::$objects[$cve].=$val;
			else self::Write($cve,$val);
		}
	}

	public static function Delete($cve) {
		unset(self::$objects[$cve]);
	}

	public static function Path($url, $destino){
		self::$objects["Ruta"][$url]=$destino;
	}

	public static function Errors($error){
		if(is_array($error))
			self::$objects["Errors"] = array_merge(self::$objects["Errors"], $error);
		else self::$objects["Errors"][]=$error;
	}
}
?>
