<?php

namespace xpl\Common\Structure;

use xpl\Common\DataStructure;

abstract class Base implements \IteratorAggregate, DataStructure 
{
	
	protected $_data = array();
	
	public function toArray() {
		return $this->_data;
	}
	
	public function count() {
		return count($this->_data);
	}
	
	public function isEmpty() {
		return empty($this->_data);
	}
	
	public function contains($value) {
		return in_array($value, $this->_data, true);
	}
	
	public function indexOf($value) {
		return array_search($value, $this->_data, true);
	}
	
	public function getIterator() {
		return new \ArrayIterator($this->_data);
	}
	
}
