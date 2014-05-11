<?php

namespace Phpf\Common\Container;

interface_exists('JsonSerializable') or require '../inc/JsonSerializable.php';

use JsonSerializable;

class Serializable extends Basic implements \Serializable, JsonSerializable {
	
	/**
	 * Returns serialized array of object vars.
	 * 
	 * @return string Serialized array of object data.
	 */
	public function serialize() {
		return serialize($this->toArray());
	}
	
	/**
	 * Unserializes and then imports vars.
	 * 
	 * @param string $serialized Serialized string of object data.
	 * @return void
	 */
	public function unserialize($serialized) {
		$this->import(unserialize($serialized));
	}
	
	/**
	 * Returns data to use when serializing to JSON.
	 * 
	 * @return array Data returned from toArray() method.
	 */
	public function jsonSerialize() {
		return $this->toArray();
	}
	
}
