<?php
abstract class Model{
	protected $db;
	protected $table_name;
	protected $table_prefix;
	protected $table_fullname;
	protected $name;
	public function __construct(string $name = null){
		if ( $name ) {
			$this->name = $name;
		} else {
			$this->getModelName();
		}

		if ( $this->name ) {
			$this->db = \sevice::getInstance()->fetch('db');
			$this->table_prefix = Yaf_Application::app()->getConfig()->db->prefix;
		}
	}
	public function select(array $option)
	{
		$this->formatTable($option);
		return $this->db->select($this->table_fullname, $option['join'], $option['columns'], $option['where']);
	}
	private function formatTable(array $option){
		isset($option['table_name']) && $this->table_name = $option['table_name'];
		isset($option['table_prefix']) && $this->table_prefix = $option['table_prefix'];
		if ( isset($option['table_fullname']) ) {
			$this->table_fullname = $option['table_fullname'];
		} else {
			$this->table_fullname = "{$this->table_prefix}{$this->table_name}";
		}
	}
	private function getModelName() {
		if(empty($this->name)){
			$name = substr(get_class($this), 0, -strlen('Model'));
			if ( $pos = strrpos($name,'\\') ) {//有命名空间
				$this->name = substr($name, $pos+1);
			}else{
				$this->name = $name;
			}
		}
		return $this->name;
	}
}
?>