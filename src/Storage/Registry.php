<?php

namespace xpl\Common\Storage;

use xpl\Common\Structure\BaseMap;

/**
 * Registry is a Map that restricts values to objects.
 * 
 * It also allows objects to be registered and loaded lazily via closures.
 */
class Registry extends BaseMap 
{
	
	/**
	 * @var array
	 */
	protected $registered = array();
	
	/**
	 * Sets an object.
	 * 
	 * @param string $key Item key.
	 * @param object $object Object instance.
	 * 
	 * @return $this
	 */
	public function set($key, $object) {
		
		if (! is_object($object)) {
			throw new \InvalidArgumentException("Registry only accepts objects, given: ".gettype($object));
		}
		
		$this->_data[$key] = $object;
		
		return $this;
	}
	
	/**
	 * Adds an array of items.
	 * 
	 * @param array $items
	 * 
	 * @return $this
	 */
	public function add(array $items) {
		
		foreach($items as $name => $object) {
			$this->set($name, $object);
		}
		
		return $this;
	}
	
	/**
	 * Returns a registered value.
	 * 
	 * @param string $key Item key.
	 * 
	 * @return mixed
	 */
	public function get($key) {
		
		if (isset($this->_data[$key])) {
			return $this->_data[$key];
		}
		
		if (isset($this->registered[$key])) {
			return $this->_data[$key] = call_user_func($this->registered[$key], $this);
		}
		
		return null;	
	}
	
	/**
	 * Registers a Closure that returns the item when invoked.
	 * 
	 * @param string $key Item key.
	 * @param \Closure $callback Closure that returns the item.
	 * 
	 * @return $this
	 */
	public function register($key, \Closure $callback) {
		
		$this->registered[$key] = $callback;
		
		return $this;
	}
	
	/**
	 * Removes an item by key, and optionally by class (in addition).
	 * 
	 * @param string $key Item key.
	 * @param string $class [Optional] Only remove the given class.
	 * 
	 * @return $this
	 */
	public function remove($key, $class = null) {
			
		if (isset($this->_data[$key])) {
			
			if (empty($class) || $this->_data[$key] instanceof $class) {
				unset($this->_data[$key]);
			}
		}
		
		if (isset($this->registered[$key])) {
			
			if (empty($class) || $class === $this->registered[$key]) {
				unset($this->registered[$key]);
			}
		}
		
		return $this;
	}
	
	/**
	 * Checks whether an key can be resolved to an object or registered closure.
	 * 
	 * @param string $key Item key.
	 * 
	 * @return boolean True if the item can be resolved to an object.
	 */
	public function exists($key) {
		return isset($this->_data[$key]) || isset($this->registered[$key]);
	}
	
}
