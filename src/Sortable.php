<?php

namespace xpl\Common;

/**
 * Contract for an object whose data can be sorted.
 */
interface Sortable {
	
	/**
	 * Sort items and retain keys.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function asort();

	/**
	 * Sort items by key.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function ksort();

	/**
	 * Sort items using natural order algo.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function natsort();

	/**
	 * Sort items using case-insensitive natural order algo.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function natcasesort();

	/**
	 * Sort items using a given callback function.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function usort($func);

	/**
	 * Sort items using a given callback function.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function uasort($func);

	/**
	 * Sort items by key using a given callback function.
	 * 
	 * @return boolean TRUE on success, or FALSE on failure.
	 */
	public function uksort($func);
	
}
