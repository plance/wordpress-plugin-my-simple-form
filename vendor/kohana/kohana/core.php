<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains the most low-level helpers methods in Kohana:
 *
 * - Environment initialization
 * - Locating files within the cascading filesystem
 * - Auto-loading and transparent extension of classes
 * - Variable and path debugging
 *
 * @package    Kohana
 * @category   Base
 * @author     Kohana Team
 * @copyright  (c) 2008-2010 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Kohana_Core {
	
	public static function debug_path($file)
	{
		return $file;
	}

	public static function exception_text(Exception $e)
	{
		return $e->getMessage();
	}
	
	/**
	 * Delete other code
	 */
	
} // End Kohana
