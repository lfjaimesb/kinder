<?php
namespace Abs;

abstract class Database{
	abstract protected function GetData($Table, $Fields='*', $Arguments=null, $Index=true);
	abstract protected function Insert($Table, $Data=array());
	abstract protected function Update($Table, $Data=array(), $Arguments=array());
	abstract protected function Delete($Table,$Arguments=array());
	abstract protected function Execute($Query, $Index=false, $All=true);
}
?>
