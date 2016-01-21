<?php
namespace Intcs;

interface Control{
	public function __toString();
	public function Run($function, $parameters=array());
}
?>
