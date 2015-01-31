<?php

namespace xpl\Common;

use xpl\Common\Structure\MapInterface;

class Object implements \IteratorAggregate, \Serializable, \JsonSerializable, MapInterface 
{
	
	public function __construct($data = null) {
		isset($data) and $this->import($data);
	}
	
	public function set($key, $value) {
		$this->$key = $value;
		return $this;
	}
	
	public function get($key) {
		return isset($this->$key) ? $this->$key : null;
	}
	
	public function has($key) {
		return isset($this->$key);
	}
	
	public function remove($key) {
		unset($this->$key);
		return $this;
	}
	
	public function offsetGet($key) {
		return $this->get($key);
	}
	
	public function offsetSet($key, $value) {
		$this->set($key, $value);
	}
	
	public function offsetUnset($key) {
		$this->remove($key);
	}
	
	public function offsetExists($key) {
		return $this->has($key);
	}
	
	public function getIterator() {
		return new \ArrayIterator($this->toArray());
	}
	
	public function count() {
		return count($this->toArray());
	}
	
	public function isEmpty() {
		return 0 == $this->count();
	}
	
	public function contains($value) {
		return in_array($value, $this->toArray(), true);
	}
	
	/**
	 * Implements \xpl\Common\Arrayable
	 * 
	 * @return array
	 */
	public function toArray() {
		return get_object_vars($this);
	}
	
	/**
	 * Implements xpl\Common\Structure\MapInterface
	 * 
	 * @return mixed
	 */
	public function indexOf($value) {
		return array_search($value, $this->toArray(), true);
	}
	
	/**
	 * Returns an indexed array of object property names.
	 * 
	 * @return array
	 */
	public function keys() {
		return array_keys($this->toArray());
	}
	
	/**
	 * Returns an indexed array of object property values.
	 * 
	 * @return array
	 */
	public function values() {
		return array_values($this->toArray());
	}
	
	/**
	 * Implements \xpl\Common\Importable
	 */
	public function import($data) {
		
		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		foreach($data as $key => $value) {
			$this->set($key, $value);
		}
		
		return $this;
	}
	
	/**
	 * @param string|int $var
	 * @param mixed $val
	 * @return void
	 */
	public function __set($key, $value) {
		$this->$key = $value;
		return $this;
	}
	
	/**
	 * @param string|int $var
	 * @return mixed
	 */
	public function __get($key) {
		return isset($this->$key) ? $this->$key : null;
	}
	
	/**
	 * @param string|int $var
	 * @return boolean
	 */
	public function __isset($key) {
		return isset($this->$key);
	}
	
	/**
	 * @param string|int $var
	 * @return void
	 */
	public function __unset($key) {
		unset($this->$key);
		return $this;
	}
	
	/**
	 * Serializes properties as an associative array.
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize($this->toArray());
	}

	/**
	 * Unserializes and adds properties.
	 *
	 * @param string $serialized
	 * @return void
	 */
	public function unserialize($serialized) {
		$this->import(unserialize($serialized));
	}
	
	/**
	 * Implements \JsonSerializable
	 */
	public function jsonSerialize() {
		return $this->toArray();
	}
	
	protected function makeArray($data) {
		
		if (is_object($data)) {
			
			if (method_exists($data, 'toArray')) {
				return $data->toArray();
			}
			
			if ($data instanceof \Traversable) {
				return iterator_to_array($data);
			}
			
			return get_object_vars($data);
		}
	
		return (array)$data;
	}
	
}
