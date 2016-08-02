<?php
class AuthController extends \Rest{
	protected $_model;
	protected function init()
	{
		parent::init();
		$this->_model = new UserModel();
	}
	public function sessionAction()
	{
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		$fun = "session_{$request_method}";
		if (method_exists($this, $fun)) {
			call_user_func([$this, $fun]);
		} else {
			$this->respone([], 403, ['status_text' => 'action not Allowed']);
		}
	}

	protected function session_post()
	{
		!$this->_post_data && $this->error_respone('param_undefined');
		!($this->_post_data['account'] && $this->_post_data['password']) && $this->error_respone('param_error');
		$this->_model->checkAccount($this->_post_data['account']);
	}

	protected function error_respone(string $error)
	{
		static $_e = [
			'param_undefined' => [400, '请求错误！'],
			'param_error' => [422, '参数错误！'],
			'account_not_exist' => [404, '账号不存在！'],
			'account_forbid' => [403, '账号已禁用！'],
			'password_error' => [401, '密码错误！'],
			'token_error' => [401, '请登录！'],
			'token_time_out' => [401, '认证超时，请重新登录！'],
			'server_error' => [500, '服务端出现错误！'],
		];
		if ( isset($_e[$error]) ) {
			$err_msg = urlencode($_e[$error][1]);
			header("info:{$err_msg}");
			$data = ['error' => $_e[$error][1]];
			$this->respone($data, $_e[$error][0]);
		}
		
	}
}
?>