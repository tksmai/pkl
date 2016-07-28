<?php
class AuthController extends Rest{
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
		switch ($error) {
			case 'param_undefined':
				$err_msg = '请求错误！';
				$code = 400;
				break;
			case 'param_error':
				$err_msg = '参数错误！';
				$code = 422;
				break;
			case 'account_not_exist':
				$err_msg = '账号不存在！';
				$code = 404;
				break;
			case 'account_forbid':
				$err_msg = '账号已禁用！';
				$code = 403;
				break;
			case 'password_error':
				$err_msg = '密码错误！';
				$code = 401;
				break;
			case 'token_error':
				$err_msg = '请登录！';
				$code = 401;
				break;
			case 'server_error':
				$err_msg = '服务端出现错误！';
				$code = 500;
				break;
		}
		$data = ['error' => $err_msg];
		$this->respone($data, $code);
	}
}
?>