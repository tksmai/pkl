<?php
/**
 * 服务类，需要在Bootstrap注册服务组件
 */
class Service{
	protected $_components; // 组件实例
	protected $_definitions; // 组件定义
	protected static $instance;
	protected function __construct(){}
	public static function getInstance(){
		if (self::$instance) {
			return self::$instance;
		}
		self::$instance = new self;
		return self::$instance;
	}
	public static function __callStatic(string $name, $arguments){
		return self::getInstance()->fetch($name);
	}
	public function __get(string $name){
		return $this->fetch($name);
	}
	public function register(string $name, $definition)
	{
		if ( is_string($definition) || is_object($definition) || is_callable($definition, true) ) {
			$this->_definitions[$name] = $definition;
		} else {
			throw new Exception('Invalid definition.');
		}
	}
	
	public function fetch(string $name)
	{
		if ( isset($this->_components[$name]) ) {
			return $this->_components[$name];
		}
		
		if ( !isset($this->_definitions[$name]) ){
			return false;
		}

		if ( is_string($this->_definitions[$name]) && class_exists($this->_definitions[$name]) ) {
			return $this->_components[$name] = new $this->_definitions[$name];
		}

		if ( is_callable($this->_definitions[$name], true) ) {
			return $this->_components[$name] = call_user_func_array($this->_definitions[$name], []);
		}

		throw new Exception("Undefined service {$name}");
	}


}
?>