<?php
/**
 * @package Phpf\Common
 */
namespace Phpf\Common;

class Env {
	
	/**
	 * Root filesystem path.
	 * @var string
	 */
	protected $root;
	
	/**
	 * Environment variables
	 */
	protected $vars = array(
		'charset' => 'UTF-8',
		'timezone' => 'UTC',
		'debug' => false,
		'namespace' => 'App',
	);
	
	/**
	 * Application directories
	 * @var array
	 */
	protected $dirs = array();
	
	/**
	 * ini settings.
	 * @var array
	 */
	protected $ini = array();
	
	/**
	 * Construct env using configuration array.
	 * 
	 * @param array $config Configuration array returned from App
	 * @return void
	 */
	public function __construct(array $config) {
		
		$this->root = $config['root'];
		unset($config['root']);
		
		$this->ini = $config['ini'];
		unset($config['ini']);
		
		foreach($config['dirs'] as $dirname => $dirpath) {
			$this->addDirectory($dirpath, $dirname);
		}
		unset($config['dirs']);
		
		if (! empty($config)) {
			foreach($config as $item => $conf) {
				$this->vars[$item] = $conf;
			}
		}
			
		/**
		 * Base absolute filesystem path with trailing slash.
		 * @var string
		 */
		define('DOCROOT', $this->root);
		
		/**
		 * Namespace for application resources (e.g. models, controllers, etc.)
		 * @var string
		 */
		define('APP_NAMESPACE', $this->vars['namespace']);
		
		$this->configurePHP();
	}
	
	/**
	 * Returns a env variable, ini setting, or property value if set.
	 * 
	 * @param string $var Name of variable/ini setting/property.
	 * @return mixed Value if set, otherwise null.
	 */
	public function get($var) {
		
		if (false !== strpos($var, '.')) {
			list($group, $item) = explode('.', $var, 2);
			return $this->getGrouped($group, $item);
		}
		
		if (isset($this->vars[$var])) {
			return $this->vars[$var];
		}
		
		if (isset($this->ini[$var])) {
			return $this->ini[$var];
		}
		
		return isset($this->$var) ? $this->$var : null;
	}
	
	/**
	 * Gets a named group of environment variables.
	 * 
	 * @param string $group Group name.
	 * @return array Group items, or empty array.
	 */
	public function getGroup($group) {
		return isset($this->vars[$group]) ? $this->vars[$group] : array();
	}
	
	/**
	 * Get an item from a named group.
	 * 
	 * @param string $group Group name.
	 * @param string $item Item name.
	 * @return mixed Item value if set, otherwise null.
	 */
	public function getGrouped($group, $item) {
		$items = $this->getGroup($group);
		return isset($items[$item]) ? $items[$item] : null;
	}
	
	/**
	 * Sets an environment variable.
	 */
	public function set($varname, $value) {
		
		if (isset($this->vars[$varname])) {
			trigger_error("Environment variable '$varname' is already set.", E_USER_NOTICE);
		} else {
			$this->vars[$varname] = $value;
		}
		
		return $this;
	}
	
	/**
	 * Adds an application directory from a path relative to root.
	 * 
	 * Optionally defines a constant with given name, value set to absolute path.
	 * 
	 * @param string $dirpath Relative directory path.
	 * @param string|null $name Name to assign to directory; if null, taken from basename().
	 * @param boolean $define_constant Whether to define a constant for dir. Default false.
	 * @return $this
	 */
	public function addDirectory($dirpath, $name = null, $define_constant = false) {
		
		if (! isset($name)) {
			$name = basename($dirpath);
		}
		
		$this->dirs[$name] = $this->root.trim($dirpath, '/\\').'/';
		
		if ($define_constant) {
			/** @ignore Constant defined from variable */
			define(strtoupper($name), $this->dirs[$name]);
		}
		
		return $this;
	}
	
	/**
	 * Returns an absolute path for the given directory name.
	 * 
	 * @param string $name Directory name, added with addDirectory().
	 * @return string Absolute path to directory, or null if not found.
	 */
	public function getPath($name) {
		return isset($this->dirs[$name]) ? $this->dirs[$name] : null;
	}
	
	/**
	 * Returns all directories.
	 * 
	 * @return array Directories
	 */
	public function getDirectories() {
		return $this->dirs;
	}
	
	/**
	 * Sets error_reporting(), ini values, and date_default_timezone_set() using the
	 * object's properties.
	 * 
	 * @return void
	 */
	protected function configurePHP() {
		
		/** Set error reporting */
		if ($this->vars['debug']) {
			error_reporting(E_ALL);
			$this->ini['display_errors'] = 1;
		} else {
			error_reporting(E_ALL ^E_STRICT);
			$this->ini['display_errors'] = 0;
		}
		
		/** Set ini settings */
		foreach($this->ini as $varname => $value) {
			ini_set($varname, $value);
		}
		
		/** Set default timezone */
		date_default_timezone_set($this->vars['timezone']);
		
		$env = $this->vars['env'];
		
		if (isset($this->vars[$env.'_on_phpconfig'])) {
			$call = $this->vars[$env.'_on_phpconfig'];
			$call($this);
		}
	}
	
}
