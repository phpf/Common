<?php

namespace xpl\Common\Structure;

interface QueueInterface extends \xpl\Common\DataStructure 
{
	
	public function enqueue($value);
	
	public function dequeue();
	
}
