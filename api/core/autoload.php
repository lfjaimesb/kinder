<?php
function load($class) {
    $directorios = [];
    $ext = explode("\\", $class, 2);

    $dir = ['Core' => OBJ, 'Abs' => ABS, 'Intcs' => INTCS, 'Lib' => LIB, 'Control' => CTRL, 'Model' => MODEL, 'Plugins' => PLUG];

    if(isset($dir[$ext[0]])) $directorios[] = $dir[$ext[0]];

    $class = $ext[count($ext) - 1];
    $class = str_replace("\\", DS, $class);

    $directorios = array_merge($directorios, [CORE, PLUGINS]);

	foreach ($directorios as $dir) {
		$archivo = $dir . $class . ".php";

		if (file_exists($archivo)) {
			require $archivo;

			return true;
		}
	}

	return false;
}

spl_autoload_register('load', true, true);
?>
