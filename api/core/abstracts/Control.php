<?php
namespace Abs;

abstract class Control{
	var $Name, $Model, $User, $Function;
	var $Post = array(), $Get = array();

	public function Run($function, $parameters=array()){
		$this->_Function = $function;
		$this->Post = $_POST;
		$this->Get = $_GET;

		unset($_POST, $_GET);
	}

	function __toString(){
		return str_replace(["Control", "\\"], "", get_class($this));
	}
}
?>
