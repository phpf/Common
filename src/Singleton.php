<?php

namespace xpl\Common;

trait Singleton
{
	private static $instances = array();
	
	final public static function instance() {
		$class = get_called_class();
		if (! isset(static::$instances[$class])) {
			static::$instances[$class] = new $class();
		}
		return static::$instances[$class];
	}

	final public function __clone() {
		throw new \RuntimeException("Cannot clone singleton: ".get_called_class());
	}
	
	final public function __sleep() {
		throw new \RuntimeException("Cannot serialize singleton: ".get_called_class());
	}
	
	final public function __wakeup() {
		throw new \RuntimeException("Cannot unserialize singleton: ".get_called_class());
	}

	protected function __construct() {
	}

}
