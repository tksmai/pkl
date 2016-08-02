<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf\Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf\Bootstrap_Abstract{
	private $_app_config;
	public function _init(Yaf\Dispatcher $dispatcher){
		\Yaf\Session::getInstance()->start();
		// 全局禁用视图的自动渲染
		$dispatcher->autoRender(FALSE);
	}
    public function _initConfig(Yaf\Dispatcher $dispatcher) {
		//把配置保存起来
		$arrConfig = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $arrConfig);
		$this->_app_config = $arrConfig->toArray();
	}

	public function _initPlugin(Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}
	public function _initService(Yaf\Dispatcher $dispatcher){
		// 注册服务
		$service = \Service::getInstance();
		$service->register('dbo', function(){
			$db_config = $this->_app_config['db'];
			$db_config['option'] = [
				\PDO::ATTR_CASE => \PDO::CASE_NATURAL,
			];
			return new \Db\Medoo($db_config);
		});
				
	}
	public function _initRoute(Yaf\Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}
	
	public function _initView(Yaf\Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
	}
}
