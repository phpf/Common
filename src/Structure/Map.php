<?php

namespace xpl\Common\Structure;

class Map extends BaseMap 
{
	
	public function __construct($data = null) {
		if (isset($data)) {
			$this->import($data);
		}
	}
	
}
