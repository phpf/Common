<?php

namespace xpl\Common;

interface DataStructure extends Arrayable, Importable, \ArrayAccess, \Countable, \Traversable 
{
	
	/**
	 * Checks whether the object is empty (contains no items).
	 * 
	 * @return boolean
	 */
	public function isEmpty();
	
	/**
	 * Checks whether the object contains a given value.
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public function contains($value);
	
}
