<?php
namespace Admin\Model\Entity;
class AttributeEntity {
	public $attribute_id;
	public $name;
	public $sort_order;
	public $attribute_group_id;
	public $group_name;
	public function exchangeArray($data)
	{
		$this->attribute_id 		= (!empty($data['attribute_id'])) ? $data['attribute_id'] : null;
		$this->name 				= (!empty($data['name'])) ? $data['name'] : null;
		$this->sort_order			= (!empty($data['sort_order'])) ? $data['sort_order'] : 0;
		$this->attribute_group_id	= (!empty($data['attribute_group_id'])) ? $data['attribute_group_id'] : null;
		$this->group_name	= (!empty($data['group_name'])) ? $data['group_name'] : 'Chưa phân loại';
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>