<?php

namespace xpl\Common\Storage;

use xpl\Common\Structure\Map;
use xpl\Common\Structure\StackInterface;

/**
 * Bin is a Map that implements StackInterface with magic methods for accessing data as properties.
 * 
 * It also has some "array_*" type methods: clear(), shift(), and unshift(). 
 */
class Bin extends Map implements StackInterface, \Serializable 
{
	
	/**
	 * Set an item value by key.
	 * 
	 * Accepts null as a key (item key will be an index).
	 * 
	 * @param string|null $key
	 * @param mixed $value
	 */
	public function set($key, $value) {
		if (null === $key) {
			$this->_data[] = $value;
		} else {
			$this->_data[$key] = $value;
		}
	}
	
	/**
	 * Removes all items, sets data to empty array.
	 */
	public function clear() {
		$this->_data = array();
	}
	
	public function push($value) {
		return array_push($this->_data, $value);
	}
	
	public function pop() {
		return array_pop($this->_data);
	}
	
	public function unshift($value) {
		return array_unshift($this->_data, $value);
	}
	
	public function shift() {
		return array_shift($this->_data);
	}
	
	public function attach($value, $prepend = false) {
		return $prepend ? $this->unshift($value) : $this->push($value);
	}
	
	public function detach($value) {
		if ($key = $this->indexOf($value)) {
			$item = $this->_data[$key];
			unset($this->_data[$key]);
			return $item;
		}
		return null;
	}
	
	/**
	 * @param string|int $var Element key/index.
	 * @return mixed
	 */
	public function __get($var) {
		return $this->get($var);
	}

	/**
	 * @param string|int $var Element key/index.
	 * @param mixed $val Element value.
	 * @return void
	 */
	public function __set($var, $val) {
		$this->set($var, $val);
	}

	/**
	 * @param string|int $var Element key/index.
	 * @return boolean
	 */
	public function __isset($var) {
		return $this->exists($var);
	}

	/**
	 * @param string|int $var Element key/index.
	 * @return void
	 */
	public function __unset($var) {
		$this->remove($var);
	}
	
	/**
	 * Serializes the object.
	 * 
	 * @return string Serialized object data.
	 */
	public function serialize() {
		return serialize($this->toArray());
	}
	
	/**
	 * Unserializes the object.
	 * 
	 * @param string $serial Serialized object data.
	 */
	public function unserialize($serial) {
		$this->import(unserialize($serial));
	}
	
}
