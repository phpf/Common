<?php

namespace xpl\Common\Structure;

/**
 * Queue is a list with First-In-First-Out order.
 */
class Queue extends Base implements QueueInterface 
{
	
	public function enqueue($value) {
		array_unshift($this->_data, $value);
	}
	
	public function dequeue() {
		return array_shift($this->_data);
	}
	
	/**
	 * Implements \xpl\Commmon\Importable
	 */
	public function import($data) {
		
		if (! is_array($data)) {
			$data = method_exists($data, 'toArray') ? $data->toArray() : (array)$data;
		}
		
		foreach($data as $value) {
			$this->enqueue($value);
		}
	}
	
	public function offsetGet($value) {
		if ($key = $this->indexOf($value)) {
			return $this->_data[$key];
		}
		return null;
	}
	
	public function offsetSet($null, $value) {
		$this->enqueue($value);
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
