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
			$this->tips_response('action_not_allow');
		}
	}

	protected function session_post()
	{
		!$this->_post_data && $this->tips_response('param_undefined');
		!($this->_post_data['account'] && $this->_post_data['password']) && $this->tips_response('param_error');
		!$this->_model->checkAccount($this->_post_data['account']) && $this->tips_response('account_not_exist');
		!$this->_model->checkPassword($this->_post_data['password']) && $this->tips_response('password_error');
		$user_info = $this->_model->getUserInfo();
		$this->response($user_info, 200);
	}

	protected function tips_response(string $tips_key)
	{
		static $_t = [
			'param_undefined' => [400, '请求错误！'],
			'param_error' => [422, '参数错误！'],
			'account_not_exist' => [404, '账号不存在！'],
			'account_forbid' => [403, '账号已禁用！'],
			'password_error' => [401, '密码错误！'],
			'token_error' => [401, '请登录！'],
			'token_time_out' => [401, '认证超时，请重新登录！'],
			'server_error' => [500, '服务端出现错误！'],
			'action_not_allow' => [403, '不允许该操作'],
			'resource_not_found' => [404, '请求资源不存在！']
		];
		if ( isset($_t[$tips_key]) ) {
			$info = urlencode($_t[$tips_key][1]);
			header("info:{$info}");
			$data = ['info' => $_t[$tips_key][1]];
			$this->response($data, $_t[$tips_key][0]);
		}
	}
}
?>