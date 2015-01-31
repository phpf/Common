<?php

namespace xpl\Common\Structure;

use xpl\Common\Arrayable;

class BaseMap extends Base implements MapInterface 
{
	
	public function get($key) {
		return isset($this->_data[$key]) ? $this->_data[$key] : null;
	}
	
	public function set($key, $value) {
		$this->_data[$key] = $value;
	}
	
	public function has($key) {
		return isset($this->_data[$key]);
	}
	
	public function remove($key) {
		unset($this->_data[$key]);
	}
	
	public function keys() {
		return array_keys($this->_data);
	}
	
	public function values() {
		return array_values($this->_data);
	}
	
	/**
	 * Implements \xpl\Commmon\Importable
	 */
	public function import($data) {
		
		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		foreach($data as $key => $value) {
			$this->set($key, $value);
		}
	}
	
	/**
	 * Implements \ArrayAccess
	 */
	
	public function offsetGet($index) {
		return $this->get($index);
	}
	
	public function offsetSet($index, $newval) {
		$this->set($index, $newval);
	}
	
	public function offsetExists($index) {
		return $this->has($index);
	}
	
	public function offsetUnset($index) {
		$this->remove($index);
	}
	
	protected function makeArray($data) {
		
		if (is_object($data)) {
			
			if ($data instanceof Arrayable) {
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
