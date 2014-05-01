<?php
/**
 * @package Phpf\Common
 */
namespace Phpf\Common;

interface ManagerInterface {
	
	/**
	 * Returns lowercase alpha string describing what the manager manages.
	 */
	public function manages();
	
}
