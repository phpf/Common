<?php

namespace Phpf\Common;

class Bootstrap {
	
	protected $docroot;
	
	protected $config_file;
	protected $boot_file;
	protected $dispatch_file;
	
	protected $actions = array();
	
	public function __construct($docroot) {
		$this->docroot = realpath($docroot).DIRECTORY_SEPARATOR;
		$this->config_file = $this->docroot.'config.php';
	}
	
	public function setConfigFile($file) {
		$this->config_file = $file;
		return $this;
	}
	
	public function setBootFile($file) {
		$this->boot_file = $file;
		return $this;
	}
	
	public function setDispatchFile($file) {
		$this->dispatch_file = $file;
		return $this;
	}
	
	public function onInit($call) {
		$this->actions['init'] = $call;
		return $this;
	}
	
	public function onBoot($call) {
		$this->actions['boot'] = $call;
		return $this;
	}
	
	public function onDispatch($call) {
		$this->actions['dispatch'] = $call;
		return $this;
	}
	
	public function __invoke() {
		
		// Include config file and merge with env defaults
		$config = $this->configure(require $this->config_file);
		
		// Create application instance
		$app = \Phpf\App::createFromConfig($config);
		
		$this->trigger('init', $app);
		
		if (! isset($this->boot_file)) {
			$this->boot_file = $app->getPath().'bootstrap.php';
		}
		
		if (! isset($this->dispatch_file)) {
			$this->dispatch_file = $app->getPath().'dispatch.php';
		}
		
		// Bootstrapping
		require $this->boot_file;
		
		$this->trigger('boot', $app);
		
		// Dispatching
		require $this->dispatch_file;
		
		$this->trigger('dispatch', $app);
	}
	
	protected function trigger($action, &$app) {
		if (isset($this->actions[$action])) {
			$call = $this->actions[$action];
			$call($app);
		}
	}
	
	protected function configure($config) {
		
		if (isset($config['environment'])) {
			switch($config['environment']) {
				case 'development' :
					$this->development($config);
					break;
				case 'production' :
					$this->production($config);
					break;
				default : 
					$this->user($config);
					break;
			}
		}
		
		return array_replace_recursive(array(
			'id'			=> 'app',
			'docroot'		=> $this->docroot,
			'environment'	=> 'default',
			'debug'			=> false,
			'timezone'		=> 'UTC',
			'charset'		=> 'UTF-8',
			'app_namespace' => 'App',
			'dirs' => array(
				'vendor'	=> 'vendor',
				'app'		=> 'app',
				'resources' => 'app/data',
				'views'		=> 'app/views',
				'assets'	=> 'app/public',
				'scripts'	=> 'app/scripts',
				'content'	=> 'app/content',
				'library'	=> 'plugins/Libraries',
				'module'	=> 'plugins/Modules',
				'storage'	=> 'etc/storage',
				'temp'		=> 'etc/temp',
			),
			'aliases' => array(
				'App'			=> 'Phpf\App',
				'Request'		=> 'Phpf\Request',
				'Response'		=> 'Phpf\Response',
				'Filesystem'	=> 'Phpf\Filesystem',
				'Router'		=> 'Phpf\Route\Router',
				'Database'		=> 'Phpf\Database\Database',
				'Events'		=> 'Phpf\Event\Manager',
				'Views'			=> 'Phpf\View\Manager',
				'Packages'		=> 'Phpf\Package\Manager',
				'Session'		=> 'Phpf\Session\Session',
				'Cache'			=> 'Phpf\Cache\Cache', // hardcoded in functions.php
				'Config'		=> 'Phpf\Config\Config',
				'Helper'		=> 'Phpf\Common\Helper',
				'Registry' 		=> 'Phpf\Common\StaticRegistry',
			),
			'packages' => array(),
			'ini' => array(
				// Unserialize objects with methods when the class has not been loaded
				'unserialize_callback_func' => 'spl_autoload_call',
			),
		), $config);
	}
	
	protected function production(array &$config) {
		// do stuff with config for production environment
		$config['debug'] = false;
	}
	
	protected function development(array &$config) {
		// do stuff with config for development environment
		$config['debug'] = true;
	}
	
	protected function user(array &$config) {
		// do stuff with config for user-defined environment
	}
	
}
