<?php
/**
 * @package Phpf\Common
 */
namespace Phpf\Common;

use Phpf\Util\Arr;

/**
 * Static-style registry.
 * 
 * Identical to Registry except static.
 */
class StaticRegistry implements \Countable
{

	protected static $data = array();

	/**
	 * Sets an object by key.
	 * 
	 * @param string $key Dot-notated object key.
	 * @param object $object Object to store.
	 * @return void
	 */
	public static function set($key, $object) {
		Arr::dotSet(static::$data, $key, $object);
	}

	/**
	 * Returns a registered object or group by key.
	 * 
	 * @param string $key Dot-notated object key.
	 * @return object Object, if set, otherwise null.
	 */
	public static function get($key) {
		return Arr::dotGet(static::$data, $key);
	}

	/**
	 * Returns true if object or group identified by given key exists.
	 * 
	 * @param string $key Dot-notated object key, or a group name.
	 * @return boolean True if given object/group exists, otherwise false.
	 */
	public static function exists($key) {
		return (bool) static::get($key);
	}
	
	/**
	 * Removes an object or group of objects by key.
	 * 
	 * @param string $key Dot-notated object key, or group name.
	 * @return void
	 */
	public static function remove($key) {
		Arr::dotUnset(static::$data, $key);
	}

	/**
	 * Returns all objects, optionally only those in a particular group.
	 * 
	 * @param null|string $group [Optional] Object group to return.
	 * @return array|null Objects (in group), otherwise null.
	 */
	public static function all($group = null) {
		
		if (isset($group)) {
			return isset(static::$data[$group]) ? static::$data[$group] : null;
		}
			
		return static::$data;
	}

	/**
	 * Returns object count.
	 * 
	 * @return int
	 */
	public static function count() {
		return count(static::$data);
	}
	
}
