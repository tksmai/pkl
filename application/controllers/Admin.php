<?php
/**
 * @name AdminController
 * @author Tsukasa Yukinoshita
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
abstract class AdminController extends Yaf_Controller_Abstract {
	public function fetchNodeAction()
	{
		$node_model = new \model('node');
		$option = [
			'join' => [],
			'columns' => '*',
			'where' => []
		];
		$list = $node_model->select($option);
		var_dump($list);
		var_dump($node_model->last_query());
	}
}
?>
