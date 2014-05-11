<?php
namespace Phpf\Common\Container;

class Data extends Basic
{

	protected $data = array();
	
	/**
	 * Gets a property value.
	 */
	public function get($var) {
		return isset($this->data[$var]) ? $this->data[$var] : null;
	}

	/**
	 * Sets a property value.
	 */
	public function set($var, $val) {
		$this->data[$var] = $val;
		return $this;
	}

	/**
	 * Returns true if a property exists.
	 */
	public function exists($var) {
		return isset($this->data[$var]);
	}

	/**
	 * Unsets a property.
	 */
	public function remove($var) {
		unset($this->data[$var]);
		return $this;
	}

	/**
	 * Returns number of data items.
	 * [Countable]
	 */
	public function count() {
		return count($this->data);
	}
	
	/**
	 * Returns iterator.
	 * [IteratorAggregate]
	 */
	public function getIterator() {
		return new \ArrayIterator($this->data);
	}

	/**
	 * Returns data array.
	 */
	public function toArray($indexed = false) {
		return $indexed ? array_values($this->data) : $this->data;
	}
	
	/**
	 * Sets data array, replacing existing array.
	 */
	public function setData(array $data) {
		$this->data = $data;
		return $this;
	}
	
	/**
	 * Adds array of to existing array.
	 */
	public function addData(array $data) {
		$this->data = array_merge($this->data, $data);
		return $this;
	}
	
	/**
	 * Returns the array of data.
	 * Identical to toArray()
	 */
	public function getData() {
		return $this->data;
	}
	
}
