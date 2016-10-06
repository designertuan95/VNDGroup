<?php
namespace Admin\Model\Entity;
class VndOptionEntity {
	public $option_id;
	public $option_key;
	public $option_value;
	public function exchangeArray($data)
	{
			$this->option_id  = (!empty($data['option_id'])) ? $data['option_id'] : null;
			$this->option_key  = (!empty($data['option_key'])) ? $data['option_key'] : null;
			$this->option_value = (!empty($data['option_value'])) ? $data['option_value'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>