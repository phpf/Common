<?php

namespace xpl\Common;

/**
 * Contract for an object where its data can be imported en masse.
 * 
 * Implementation should either successfully import the data, or
 * throw an UnexpectedValueException.
 */
interface Importable 
{
	
	/**
	 * Import some data to the object.
	 * 
	 * @param mixed $data
	 * @return void
	 * @throws \UnexpectedValueException if data is invalid.
	 */
	public function import($data);
	
}
