<?php
class AdminController extends \Rest {
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
		$this->respone($_REQUEST, 401);
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

}
?>
