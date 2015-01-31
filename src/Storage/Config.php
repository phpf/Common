<?php

namespace xpl\Common\Storage;

/**
 * Config is a Container that allows setting a parent 
 * (i.e. the object for which it holds config values)
 */
class Config extends Container 
{
	
	/**
	 * @var object
	 */
	protected $parent;
	
	public function __construct($data = null) {
		if (isset($data)) {
			$this->import($data);
		}
	}
	
	/**
	 * Sets the config parent object.
	 * 
	 * @param object $object
	 * 
	 * @return $this
	 * 
	 * @throws \InvalidArgumentException if given a non-object.
	 */
	public function setParent($object) {
		
		if (! is_object($object)) {
			throw new \InvalidArgumentException("Expecting object, given: ".gettype($object));
		}
		
		$this->parent = $object;
		return $this;
	}
	
	/**
	 * Returns the parent object, if one is set, otherwise null.
	 * 
	 * @return object|null
	 */
	public function getParent() {
		return isset($this->parent) ? $this->parent : null;
	}
	
	/**
	 * Set method returns the previous value.
	 * 
	 * @param string $key Item key.
	 * @param mixed $value New value.
	 * 
	 * @return mixed Previous item value.
	 */
	public function set($key, $value) {
		
		$previous = $this->get($key);
		
		parent::set($key, $value);
		
		return $previous;
	}

}
