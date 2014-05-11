<?php
/**
 * Fallback for PHP < 5.4
 */
interface JsonSerializable {

	public function jsonSerialize();

}