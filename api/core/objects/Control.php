<?php
namespace Core;
use Core\Config;
use Abs\Control as AbsControl;
use Intcs\Control as IntControl;

class Control extends AbsControl implements IntControl{
	function __construct(){
		$this->Name = $this;
		$model = "Model\\".$this;

		if(class_exists($model, true)){
			$this->{$this->Name} = new $model;
		}else{
			echo json_encode(["data"=>"Error al recuperar datos"]);
		}
	}

	function Run($function, $parameters=array()){
		parent::Run($function, $parameters);

		$bdr = true;

		if(is_callable(array($this, "before")))
			$bdr = call_user_func_array(array($this, "before"), ["function"=>$function, "parameters"=>$parameters]);

		if($bdr)
			call_user_func_array(array($this, $function),$parameters);

		if(is_callable(array($this, "after")))
			call_user_func_array(array($this,"after"), ["function"=>$function, "parameters"=>$parameters]);
	}
}
?>
