<?php
namespace Admin\Model\Entity;
class TagsEntity {
	public $tags_id;
	public $tag_name;
	public function exchangeArray($data)
	{
			$this->tags_id  = (!empty($data['tags_id'])) ? $data['tags_id'] : null;
			$this->tag_name = (!empty($data['tag_name'])) ? $data['tag_name'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>