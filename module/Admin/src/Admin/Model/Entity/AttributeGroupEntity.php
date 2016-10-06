<?php
namespace Admin\Model\Entity;
class AttributeGroupEntity {
	public $attribute_group_id;
	public $sort_order;
	public $name;

	public function exchangeArray($data)
	{
		$this->attribute_group_id	= (!empty($data['attribute_group_id'])) ? $data['attribute_group_id'] : null;
		$this->name 				= (!empty($data['name'])) ? $data['name'] : null;
		$this->sort_order			= (!empty($data['sort_order'])) ? $data['sort_order'] : 0;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>