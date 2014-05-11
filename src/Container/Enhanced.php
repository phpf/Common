<?php

namespace Phpf\Common\Container;

use BadMethodCallException;
use Closure;

class Enhanced extends Basic {

	/**
	 * Returns a property value - if closure, executes and returns results.
	 *
	 * @param string $var Property name.
	 * @return mixed Property value if set, otherwise null. If the value is a
	 * closure, it will be executed and the results will be returned.
	 */
	public function get($var) {
		return isset($this->$var) ? $this->result($this->$var) : null;
	}

	/**
	 * Returns raw value if set. Does not execute if value is a closure.
	 *
	 * @param string $var Property name.
	 * @return mixed Value if set, otherwise null.
	 */
	public function raw($var) {
		return isset($this->$var) ? $this->$var : null;
	}

	/**
	 * Executes callable properties - e.g. closures or invokable objects.
	 *
	 * Allows container to have property-bound methods.
	 *
	 * @throws BadMethodCallException if function is not a callable property.
	 */
	public function __call($func, $params) {

		if (isset($this->$func) && is_callable($this->$func)) {

			$call = $this->$func;

			switch(count($params)) {
				case 0 :
					return $call();
				case 1 :
					return $call($params[0]);
				case 2 :
					return $call($params[0], $params[1]);
				case 3 :
					return $call($params[0], $params[1], $params[2]);
				case 4 :
					return $call($params[0], $params[1], $params[2], $params[3]);
				default :
					return call_user_func_array($call, $params);
			}
		}

		throw new BadMethodCallException("Unknown method '$func'.");
	}

	/**
	 * If value is a closure, executes it before returning. Otherwise returns
	 * original value.
	 *
	 * @param mixed $var
	 * @return mixed Original value or result of closure.
	 */
	protected function result($var) {
		return ($var instanceof Closure) ? $var() : $var;
	}

}
