<?php

namespace Phpf\Common;

class Container implements \ArrayAccess, \Countable, \IteratorAggregate
{

	/**
	 * Sets a property value.
	 *
	 * @param string $var Property name.
	 * @param mixed $val Property value.
	 * @return $this
	 */
	public function set($var, $val) {
		$this->$var = $val;
		return $this;
	}

	/**
	 * Returns a property value.
	 *
	 * @param string $var Property name.
	 * @return mixed Property value if set, otherwise null.
	 */
	public function get($var) {
		return isset($this->$var) ? $this->$var : null;
	}

	/**
	 * Returns true if a property exists.
	 *
	 * @param string $var Property name.
	 * @return boolean True if property exists and is not null, otherwise false.
	 */
	public function exists($var) {
		return isset($this->$var);
	}

	/**
	 * Unsets a property.
	 *
	 * @param string $var Property name.
	 * @return $this
	 */
	public function remove($var) {
		unset($this->$var);
		return $this;
	}

	/**
	 * Returns number of data items.
	 * [Countable]
	 *
	 * @return int Number of container items.
	 */
	public function count() {
		return count($this->toArray());
	}

	/**
	 * Returns iterator.
	 * [IteratorAggregate]
	 *
	 * @return ArrayIterator
	 */
	public function getIterator() {
		return new \ArrayIterator($this);
	}

	/**
	 * Returns object properties as array.
	 *
	 * @param boolean $indexed If true, returns indexed array (otherwise
	 * associative). Default false.
	 * @return array Object as array.
	 */
	public function toArray($indexed = false) {
		return iterator_to_array($this, ! $indexed);
	}

	/**
	 * Imports an array or object containing data as properties.
	 *
	 * @param array|object $data Array or object containing properties to import.
	 * @return $this
	 */
	public function import($data) {

		if (! is_array($data) && ! $data instanceof \Traversable) {
			$data = (array)$data;
		}

		foreach ( $data as $k => $v ) {
			$this->set($k, $v);
		}

		return $this;
	}

	/**
	 * Magic __set()
	 *
	 * @param string $var Property name.
	 * @param mixed $val Property value.
	 * @return void
	 */
	public function __set($var, $val) {
		$this->set($var, $val);
	}

	/**
	 * Magic __get()
	 *
	 * @param string $var Property name.
	 * @return mixed Property value if set, otherwise null. If the value is a
	 * closure, it will be executed and the results will be returned.
	 */
	public function __get($var) {
		return $this->get($var);
	}

	/**
	 * Magic __isset()
	 *
	 * @param string $var Property name.
	 * @return boolean True if property exists and is not null, otherwise false.
	 */
	public function __isset($var) {
		return $this->exists($var);
	}

	/**
	 * Magic __unset()
	 *
	 * @param string $var Property name.
	 * @return void
	 */
	public function __unset($var) {
		$this->remove($this->$var);
	}
	
	/**
	 * Sets a property value.
	 * [ArrayAccess]
	 *
	 * @param string $var Property name.
	 * @param mixed $val Property value.
	 * @return void
	 */
	public function offsetSet($index, $newval) {
		$this->set($index, $newval);
	}

	/**
	 * Returns a property value.
	 * [ArrayAccess]
	 *
	 * @param string $var Property name.
	 * @return mixed Property value if set, otherwise null. If the value is a
	 * closure, it will be executed and the results will be returned.
	 */
	public function offsetGet($index) {
		return $this->get($index);
	}

	/**
	 * Returns true if a property exists.
	 * [ArrayAccess]
	 *
	 * @param string $var Property name.
	 * @return boolean True if property exists and is not null, otherwise false.
	 */
	public function offsetExists($index) {
		return $this->exists($index);
	}

	/**
	 * Unsets a property.
	 * [ArrayAccess]
	 *
	 * @param string $var Property name.
	 * @return void
	 */
	public function offsetUnset($index) {
		$this->remove($index);
	}

}
