<?php
namespace Db;
class Driver{
	private static $_dbo;
	public static function getInstance(array $db_config)
	{
		if ( self::$_dbo ) {
			return $_dbo;
		}
		$db_config['option'] = [
			\PDO::ATTR_CASE => \PDO::CASE_NATURAL
		];
		return self::$_dbo = new Meedo($db_config);
	}
	protected function __construct(){}
}
?>