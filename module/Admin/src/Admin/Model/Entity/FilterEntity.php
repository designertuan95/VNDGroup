<?php
namespace Admin\Model\Entity;
class FilterEntity{
	public $filter_id;
	public $name;
	public $sort_order; 
	public $parent_id;
	public function exchangeArray($data){
		$this->filter_id 		= (!empty($data['filter_id'])) ? $data['filter_id'] : null;
		$this->name 			= (!empty($data['name'])) ? $data['name'] : null;
		$this->sort_order 		= (!empty($data['sort_order'])) ? $data['sort_order'] : 0;
		$this->parent_id 		= (!empty($data['parent_id'])) ? $data['parent_id'] : 0;
	}
	public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
?>