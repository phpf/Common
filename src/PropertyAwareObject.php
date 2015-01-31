<?php

namespace xpl\Common;

/**
 * An object which restricts values to class properties.
 */
abstract class PropertyAwareObject extends Object {
	
	public function set($key, $value) {
			
		if (! property_exists($this, $key)) {
			throw new \InvalidArgumentException("Attempting to set invalid property: '$key'.");
		}
		
		$this->$key = $value;
		
		return $this;
	}
	
	public function get($key) {
		return property_exists($this, $key) ? $this->$key : null;
	}
	
	public function has($key) {
		return property_exists($this, $key) ? isset($this->$key) : null;
	}
	
	public function remove($key) {
		
		if (property_exists($this, $key)) {
			unset($this->$key);
		}
		
		return $this;
	}
	
}
