<?php

namespace xpl\Common\Storage;

use xpl\Common\Sortable;
use xpl\Common\Arrayable;

/**
 * Collection is a Bin that implements Sortable.
 * 
 * It also has several methods that mimic those of several array_*() functions.
 */
class Collection extends Bin implements Sortable 
{
	
	public function walk($callback, $userdata = null) {
		return array_walk($this->_data, $callback, $userdata);
	}
	
	/**
	 * Merges the given items into the collection.
	 * 
	 * @param array|Arrayable $data
	 * @return void
	 */
	public function merge($data) {

		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		$this->_data = array_merge($this->_data, $data);
	}
	
	/**
	 * Replaces items in the collection with those given.
	 * 
	 * @param array|Arrayable $data
	 * @return void
	 */
	public function replace($data) {

		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		$this->_data = array_replace($this->_data, $data);
	}
	
	/**
	 * Filters the elements using a callback function and returns a new collection.
	 * 
	 * @return \xpl\Common\Storage\Collection
	 */
	public function filter($func) {
		return new static(array_filter($this->_data, $func));
	}
	
	/**
	 * Applies a callback function to each element and returns a new Collection.
	 * 
	 * @param callable $func
	 * @return \xpl\Common\Storage\Collection
	 */
	public function map($func) {
		return new static(array_map($func, $this->_data));
	}
	
	/**
	 * Extracts a slice of the list and returns a new Collection.
	 * 
	 * @param integer $offset Position to start extracting items at.
	 * @param integer $length [Optional] Number of items to extract.
	 * @return \xpl\Common\Storage\Collection
	 */
	public function slice($offset, $length = null) {
		return new static(array_slice($this->_data, $offset, $length, true));
	}
	
	/**
	 * Computes the intersection with the given array and returns a new collection.
	 * 
	 * @param array|\xpl\Common\Arrayable $data
	 * @return \xpl\Common\Storage\Collection
	 */
	public function intersect($data) {
		
		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		return new static(array_intersect_assoc($this->_data, $data));
	}
	
	/**
	 * Returns a new collection containing items that do not appear in $data.
	 * 
	 * @param array|\xpl\Common\Arrayable
	 * @return \xpl\Common\Storage\Collection
	 */
	public function diff($data) {

		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		return new static(array_diff_assoc($this->_data, $data));
	}

	/**
	 * Returns a new collection containing items whose keys do not appear in $data. 
	 * 
	 * @param array|\xpl\Common\Arrayable $data
	 * @return \xpl\Common\Storage\Collection
	 */
	public function keyDiff($data) {

		if (! is_array($data)) {
			$data = $this->makeArray($data);
		}
		
		return new static(array_diff_key($this->_data, $data));
	}
	
	/**
	 * Filters the items by key and returns a new collection.
	 * 
	 * @param callable $func
	 * @return \xpl\Common\Storage\Collection
	 */
	public function keyFilter($func) {
		
		$filtered = array_filter($this->keys(), $func);
		
		return new static(array_intersect_key($this->_data, array_flip($filtered)));
	}
	
	/**
	 * Applies a callback function to each item key and returns a new collection.
	 * 
	 * @param callable $func
	 * @return \xpl\Common\Storage\Collection
	 */
	public function keyMap($func) {
		
		return new static(array_combine(array_map($func, $this->keys()), $this->values()));
	}
	
	/**
	 * @param \Closure $func
	 */
	public function each(\Closure $func) {
		
		$func = $func->bindTo($this, get_class($this));
		
		foreach($this->_data as $key => $value) {
			$func($value, $key);
		}
	}
	
	/**
	 * Returns the sum of the collection values.
	 * 
	 * @return int|float
	 */
	public function sum() {
		return array_sum($this->_data);
	}
	
	/**
	 * Returns the product of the collection values.
	 * 
	 * @return int|float
	 */
	public function product() {
		return array_product($this->_data);
	}
	
	/**
	 * Selects 1 or more random keys from the collection.
	 * 
	 * @param integer $num Number of keys to retrieve
	 * @return mixed Returns the key if $num = 1, otherwise an indexed array of keys.
	 */
	public function rand($num = 1) {
		return array_rand($this->_data, $num);
	}
	
	public function asort() {
		return asort($this->_data);
	}

	public function ksort() {
		return ksort($this->_data);
	}

	public function natsort() {
		return natsort($this->_data);
	}

	public function natcasesort() {
		return natcasesort($this->_data);
	}
	
	public function usort($func) {
		return usort($this->_data, $func);
	}

	public function uasort($func) {
		return uasort($this->_data, $func);
	}

	public function uksort($func) {
		return uksort($this->_data, $func);
	}
	
}
