<?php
/**
 * @package Phpf\Common
 */
namespace Phpf\Common;

/**
 * Static object registry.
 */
class StaticRegistry
{

	protected static $data = array();

	/**
	 * Sets an object by key.
	 */
	public static function set($key, $object) {
			
		if (false !== strpos($key, '.')) {
		
			list($group, $key) = explode('.', $key, 2);
		
			if (! isset(static::$data[$group])) {
				static::$data[$group] = array();
			}
		
			static::$data[$group][$key] = $object;
		
		} else {
			static::$data[$key] = $object;
		}
	}

	/**
	 * Returns a registered object or group by key.
	 */
	public static function get($key) {
		
		if (false !== strpos($key, '.')) {
				
			list($group, $key) = explode('.', $key, 2);
			
			return isset(static::$data[$group][$key]) ? static::$data[$group][$key] : null;
		}
		
		return isset(static::$data[$key]) ? static::$data[$key] : null;
	}

	/**
	 * Returns true if object or group identified by given key exists.
	 */
	public static function exists($key) {
		
		if (false !== strpos($key, '.')) {
		
			list($group, $key) = explode('.', $key, 2);
		
			return isset(static::$data[$group][$key]);
		}
		
		return isset(static::$data[$key]);
	}

	/**
	 * Returns all objects, optionally only those in a particular group.
	 */
	public static function all($group = null) {
		
		if (isset($group)) {
			return isset(static::$data[$group]) ? static::$data[$group] : null;
		}
			
		return static::$data;
	}

	/**
	 * Adds an object to a given group.
	 */
	public static function addToGroup($group, $key, $object) {
			
		if (! isset(static::$data[$group])) {
			static::$data[$group] = array();
		}
		
		static::$data[$group][$key] = $object;
	}

	/**
	 * Returns an object from a given group.
	 */
	public static function getFromGroup($group, $key) {
		return isset(static::$data[$group][$key]) ? static::$data[$group][$key] : null;
	}

	/**
	 * Returns array of objects registered to a particular group.
	 */
	public static function getGroup($group) {
		return static::all($group);
	}

}
