<?php
namespace Admin\Model\Entity;
class CategoryEntity {
	public $category_id;
	public $name;
	public $description;
	public $parent_id;
	public $sort_order;
	public $image;
	public $status;
	public $date_added;
	public $date_modified;
	public $meta_title;
	public $meta_description;
	public $meta_keyword;
	public function exchangeArray($data)
	{
		$this->category_id = (!empty($data['category_id'])) ? $data['category_id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->description = (!empty($data['description'])) ? $data['description'] : null;
		$this->parent_id = (!empty($data['parent_id'])) ? $data['parent_id'] : null;
		$this->sort_order = (!empty($data['sort_order'])) ? $data['sort_order'] : null;
		$this->image = (!empty($data['image'])) ? $data['image'] : null;
		$this->status = (!empty($data['status'])) ? $data['status'] : 0;
		$this->date_added = (!empty($data['date_added'])) ? $data['date_added'] : null;
		$this->date_modified = (!empty($data['date_modified'])) ? $data['date_modified'] : null;
		$this->meta_title = (!empty($data['meta_title'])) ? $data['meta_title'] : null;
		$this->meta_description = (!empty($data['meta_description'])) ? $data['meta_description'] : null;
		$this->meta_keyword = (!empty($data['meta_description'])) ? $data['meta_description'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>