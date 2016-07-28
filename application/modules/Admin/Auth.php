<?php
class AuthController extends Rest{
	protected $_post_data;
	public function init()
	{
		$this->_post_data = json_decode(file_get_contents('php://input'));
	}
	public function indexAction()
	{
		$model = new UserModel();
		$model->hello();
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

	}
}
?>