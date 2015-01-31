<?php

namespace xpl\Common;

/**
 * An object that "hides" its data internally.
 * 
 * This takes advantage of a "feature"/bug in ArrayObject using STD_PROP_LIST.
 * 
 * Both array-access and property access work as expected, however, no properties
 * will be shown if the object is var_dump()'d.
 */
class HiddenObject extends \ArrayObject implements Arrayable, Importable {
	
	public function __construct($data = array()) {
		parent::__construct($data, \ArrayObject::STD_PROP_LIST);
	}
	
	public function offsetGet($var) {
		return parent::offsetExists($var) ? parent::offsetGet($var) : null;
	}
	
	public function __get($var) {
		return $this->offsetGet($var);
	}
	
	public function __set($var, $value) {
		$this->offsetSet($var, $value);
	}
	
	public function __isset($var) {
		return $this->offsetExists($var);
	}
	
	public function __unset($var) {
		$this->offsetUnset($var);
	}
	
	public function get($var) {
		return $this->offsetGet($var);
	}
	
	public function set($var, $val) {
		$this->offsetSet($var, $val);
		return $this;
	}
	
	public function has($var) {
		return $this->offsetExists($var);
	}
	
	public function remove($var) {
		$this->offsetUnset($var);
		return $this;
	}
	
	public function import($data) {
			
		if (! is_array($data)) {
			$data = is_callable(array($data, 'toArray')) ? $data->toArray() : (array)$data;
		}
		
		foreach($data as $key => $value) {
			$this->offsetSet($key, $value);
		}
		
		return $this;
	}
	
	public function toArray() {
		return iterator_to_array($this);
	}
	
}
