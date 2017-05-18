<?php
if(defined('SYSPATH') == false)
{
	define('SYSPATH', true);
}

/**
 * Kohana_Upload
 * Upload
 */


$class_ar = array(
	'Kohana_Core'		=> '/kohana/core.php',
	'Kohana'			=> '/kohana.php',
	'Kohana_Exception'	=> '/kohana/exception.php',
);

foreach($class_ar as $class => $path)
{
	if(class_exists($class) == false)
	{
		include_once __DIR__.$path;
	}
}

unset($class_ar);