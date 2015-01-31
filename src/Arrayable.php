<?php

namespace xpl\Common;

/**
 * Contract for a class that can return its data as an array.
 */
interface Arrayable
{

	/**
	 * Return the list items as a native PHP array.
	 *
	 * @return array
	 */
	public function toArray();

}
