<?php
/**
 * @name AdminController
 * @author Tsukasa Yukinoshita
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class AdminController extends Yaf_Controller_Abstract {
	protected $_post_data;
	public function init()
	{
		$this->_post_data = json_decode(file_get_contents('php://input'));
	}
	public function fetchNodeAction()
	{
		$group_model = new \model('group');
		$node_model = new \model('node');
		$option = [
			'join' => [],
			'columns' => '*',
			'where' => [
				'ORDER' => [
					'sort' => 'DESC',
				],
				'AND' => [
					'status' => '1',
				]
			]
		];
		$list = $group_model->select($option);
		foreach ($list as &$group) {
			$g_option = [
				'join' => [],
				'columns' => '*',
				'where' => [
					'AND' => [
						'group_id' => $group['id'],
						'level' => '2',
						'status' => '1',
						'is_show' => '1',
					],
					'ORDER' => [
						'sort' => 'DESC'
					]
				]
			];
			$group['node_list'] = $node_model->select($g_option);
		}
		header('Access-Control-Allow-Origin: *');
		$this->dataTransfer($list, false);
	}

	public function sessionAction()
	{
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		$fun = "{$request_method}_session";
		if (method_exists($this, $fun)) {
			call_user_func([$this, $fun]);
		} else {
			$this->respone([], 403, ['status_text' => 'action not Allowed']);
		}
	}

	protected function get_session()
	{
		$this->respone($_REQUEST, 200);
	}

	protected function dataTransfer(array $org_data, bool $is_page, $err_msg = null)
	{
		if ( $org_data ) {
			$status = 1;
			$info = 'success';
		} else {
			$status = 0;
			$info = is_string($err_msg) ? $err_msg : 'no data';
			!is_string($err_msg) && $org_data = (array)$err_msg;
		}
		$data = [
			'status' => $status,
			'info' => $info,
		];
		if ( $is_page ) {
			$data['listRows'] = $_REQUEST['listRows'] ?? 15;
			$data['p'] = $_REQUEST['p'] ?? 1;
		}
		$data['data'] = $org_data;
		$this->ajaxTransfer($data, 1);
	}

	protected function promptTransfer(int $status, string $info = null, array $data = null)
	{
		$this->ajaxTransfer([
			'status' => $status,
			'info' => $info,
			'data' => $data
		], 0);
	}

	protected function respone($data, int $http_code = null, array $option = null)
	{
		// @$json_option = (int)$option['json_option'] ?? 0;
		// @$json_depth = (int)$option['json_depth'] ?? 512;
		$http_code = $http_code ?? 200;
		$status_text = (string)$option['status_text'] ?? null;
		header('Content-Type:application/json; charset=utf-8');
		$this->sendHttpStatus($http_code, $status_text);
		exit(json_encode($data));
	}
	protected function sendHttpStatus(int $code, string $custom_text = null) {
		$_status = array(
			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',
			// Success 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Moved Temporarily ',  // 1.1
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			// 306 is deprecated but reserved
			307 => 'Temporary Redirect',
			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			509 => 'Bandwidth Limit Exceeded'
		);
		$custom_text = $custom_text ?? $_status[$code];
		if(isset($_status[$code])) {
			header('HTTP/1.1 '.$code.' '.$custom_text);
			// 确保FastCGI模式下正常
			header('Status:'.$code.' '.$custom_text);
		}
	}
}
?>
