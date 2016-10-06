<?php
namespace Admin\Model\Entity;
class MenuEntity {
	public $menu_id;
	public $menu_name;
	public $parent_id;
	public $icon;
	public $description;
	public $image;
	public $status;
	public function exchangeArray($data)
	{
		$this->menu_id = (!empty($data['menu_id'])) ? $data['menu_id'] : null;
		$this->menu_name = (!empty($data['menu_name'])) ? $data['menu_name'] : null;
		$this->parent_id = (!empty($data['parent_id'])) ? $data['parent_id'] : null;
		$this->icon = (!empty($data['icon'])) ? $data['icon'] : null;
		$this->description = (!empty($data['description'])) ? $data['description'] : null;
		$this->image = (!empty($data['image'])) ? $data['image'] : null;
		$this->status = (!empty($data['status'])) ? $data['status'] : null;
	}
	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>