<?php
class Model{
	protected $db;
	protected $table_name;
	protected $table_prefix;
	protected $table_fullname;
	// protected $name;
	public function __construct(string $name = null){
		if ( $name ) {
			$this->table_name = $name;
		} else {
			$this->table_name = $this->getModelName();
		}
		// $this->table_name = 
		if ( $this->table_name ) {
			$this->db = \Service::getInstance()->fetch('dbo');
			$this->table_prefix = Yaf_Application::app()->getConfig()->db->prefix;
		}
		$this->table_fullname = "{$this->table_prefix}{$this->table_name}";
	}
	public function select(array $option)
	{
		@!$option['join'] && $option['join'] = [];
		@!$option['columns'] && $option['columns'] = '*';
		$this->formatTable($option);
		if ( $option['join'] ) {
			return $this->db->select($this->table_fullname, $option['join'], $option['columns'], $option['where']);
		}
		return $this->db->select($this->table_fullname, $option['columns'], $option['where']);		
	}
	public function last_query()
	{
		return $this->db->last_query();
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
		$name = substr(get_class($this), 0, -strlen('Model'));
		if ( $pos = strrpos($name,'\\') ) {//有命名空间
			$name = substr($name, $pos+1);
		}
		return $name;
	}
}
?>