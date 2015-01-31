<?php

namespace xpl\Common\Structure;

interface MapInterface extends \xpl\Common\DataStructure 
{
	
	public function get($key);
	
	public function set($key, $value);
	
	public function has($key);
	
	public function remove($key);
	
	public function indexOf($value);
	
	public function keys();
	
	public function values();
	
}
