<?php

namespace xpl\Common\Structure;

interface StackInterface extends \xpl\Common\DataStructure 
{
	
	public function push($value);
	
	public function pop();
	
}
