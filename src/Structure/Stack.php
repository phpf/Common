<?php

namespace xpl\Common\Structure;

/**
 * Stack is a list with Last-In-First-Out order.
 */
class Stack extends Base implements StackInterface 
{
	
	public function push($value) {
		array_push($this->_data, $value);
	}
	
	public function pop() {
		return array_pop($this->_data);
	}
	
	/**
	 * Implements \xpl\Commmon\Importable
	 */
	public function import($data) {
		
		if (! is_array($data)) {
			$data = method_exists($data, 'toArray') ? $data->toArray() : (array)$data;
		}
		
		foreach($data as $value) {
			$this->push($value);
		}
	}
	
	public function offsetGet($value) {
		if ($key = $this->indexOf($value)) {
			return $this->_data[$key];
		}
		return null;
	}
	
	public function offsetSet($null, $value) {
		$this->push($value);
	}
	
	public function offsetExists($value) {
		return $this->contains($value);
	}
	
	public function offsetUnset($value) {
		if ($key = $this->indexOf($value)) {
			$item = $this->_data[$key];
			unset($this->_data[$key]);
			return $item;
		}
		return null;
	}
	
}
