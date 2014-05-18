<?php

namespace Phpf\Common;

use Phpf\Util\Arr;

/**
 * Object-style registry.
 * 
 * Identical to StaticRegistry, except not static.
 */
class Registry implements \Countable
{
	
	protected $data = array();

	/**
	 * Sets an object by key.
	 * 
	 * @param string $key Dot-notated object key.
	 * @param object $object Object to store.
	 * @return $this
	 */
	public function set($key, $object) {
		Arr::dotSet($this->data, $key, $object);
		return $this;
	}

	/**
	 * Returns a registered object or group by key.
	 * 
	 * @param string $key Dot-notated object key.
	 * @return object Object, if set, otherwise null.
	 */
	public function get($key) {
		return Arr::dotGet($this->data, $key);
	}

	/**
	 * Returns true if object or group identified by given key exists.
	 * 
	 * @param string $key Dot-notated object key, or a group name.
	 * @return boolean True if given object/group exists, otherwise false.
	 */
	public function exists($key) {
		return (bool) $this->get($key);
	}
	
	/**
	 * Removes an object or group of objects by key.
	 * 
	 * @param string $key Dot-notated object key, or group name.
	 * @return $this
	 */
	public function remove($key) {
		Arr::dotUnset($this->data, $key);
		return $this;
	}

	/**
	 * Returns all objects, optionally only those in a particular group.
	 * 
	 * @param null|string $group [Optional] Object group to return.
	 * @return array|null Objects (in group), otherwise null.
	 */
	public function all($group = null) {
		
		if (isset($group)) {
			return isset($this->data[$group]) ? $this->data[$group] : null;
		}
			
		return $this->data;
	}
	
	/**
	 * Returns object count.
	 * 
	 * @return int
	 */
	public function count() {
		return count($this->data);
	}
	
}
