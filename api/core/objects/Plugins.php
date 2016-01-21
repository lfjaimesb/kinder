<?php
namespace Core;
use Core\Config;

class Plugins {
	var $NameForm, $Script;

	var $tags=array(
		"form"=>"<form id='%s' action='%s' method='%s' %s>",
		"input"=>"<input type='%s' name='%s' id='%s' value='%s' %s />",
		"submit"=>"<input type='%s' %s />",
		"textarea"=>"<textarea name='%s' id='%s' %s>%s</textarea>",
		"select"=>"<select name='%s' id='%s' %s>%s</select>",
		"javascript"=>"<script src='%s.js' type='text/javascript'></script>",
		"meta" => "<meta %s='%s' content='%s' />",
		"label" => "<label for='%s' %s>%s</label>"
	);

	function __construct(){
		$this->NameForm = ucwords(substr(Config::Reader('control'),0,-7)) . ucwords(Config::Reader('function') );
	}

	function __toString(){
		return get_class($this);
	}
}

?>
