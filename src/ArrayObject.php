<?php

namespace xpl\Common;

class ArrayObject extends \ArrayObject implements Arrayable, Importable
{
	
	public function __construct(array $data = array()) {
		parent::__construct($data, \ArrayObject::ARRAY_AS_PROPS);
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
	
	/**
	 * Implements \xpl\Common\Importable
	 */
	public function import($data) {
		
		if (! is_array($data)) {
			$data = is_callable(array($data, 'toArray')) ? $data->toArray() : (array)$data;
		}
		
		foreach($data as $key => $value) {
			$this[$key] = $value;
		}
		
		return $this;
	}
	
	/**
	 * Implements \xpl\Common\Arrayable
	 * 
	 * @return array
	 */
	public function toArray() {
		return $this->getArrayCopy();
	}
	
}
