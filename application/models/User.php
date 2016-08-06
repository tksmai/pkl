<?php
class UserModel extends Model
{
	private $user_info = [];

	public function checkAccount(string $account)
	{
		$option = [
			'where' => [
				'AND' => [
					'account' => $account,
					'status' => '1'
				]
			]
		];
		$user_info = $this->select($option); // 这里查询得到的是二维数组，待定化成一维数组
		if ( $user_info ) {
			$this->user_info = $user_info[0];
			return true;
		}
		return false;
	}

	public function checkPassword(string $password)
	{
		$password = md5($password);
		@$bool = $password == $this->user_info['password'];
		return $bool;
	}

	public function getUserInfo()
	{
		if ( !$this->user_info ) {
			$this->err_msg = 'please check accoutn first!';
			return false;
		}

		$user_info = $this->user_info;
		unset($user_info['password']);
		return $user_info;
	}
}
?>