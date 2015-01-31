<?php

namespace xpl\Common\Storage;

class LockableRegistry extends Registry 
{
	
	protected $_locked = array();
	
	public function set($key, $object) {
		
		if (isset($this->_locked[$key])) {
			throw new \RuntimeException("Cannot set '$key' - object is locked.");
		}
		
		parent::set($key, $object);
		
		return $this;
	}
	
	public function remove($key) {
		
		if (isset($this->_locked[$key])) {
			throw new \RuntimeException("Cannot remove '$key' - object is locked.");
		}
		
		unset($this->_data[$key]);
		
		return $this;
	}
	
	public function register($key, \Closure $callback) {
		
		if (isset($this->_locked[$key])) {
			throw new \RuntimeException("Cannot register '$key' - provider is locked.");
		}
		
		parent::register($key, $callback);
		
		return $this;
	}
	
	public function lock($key) {
		
		if (func_num_args() === 1) {
		
			if (is_object($key)) {
				$key = $this->indexOf($key);
			}
			
			if ($this->has($key) || isset($this->registered[$key])) {
				$this->_locked[$key] = 1;
			}
		
		} else {
			array_map(array($this, 'lock'), func_get_args());
		}
		
		return $this;
	}
	
	public function unlock($key) {
			
		if (func_num_args() === 1) {
				
			if (is_object($key)) {
				$key = $this->indexOf($key);
			}
			
			unset($this->_locked[$key]);
		
		} else {
			array_map(array($this, 'unlock'), func_get_args());
		}
		
		return $this;
	}
	
}
