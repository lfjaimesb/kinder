<?php
namespace Intcs;

interface Model {
	public function __call($name, $arguments);
	public function find($fields = 'all', $options = []);
	public function save($data);
	public function modify($data, $options = []);
	public function del($options = []);
	public function query($query,$indice=true,$recuperar=false);
}
?>
