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
		$user_info = $this->select($option);
		var_dump($this->last_query());
		var_dump($user_info);
	}
}
?>