<?php
namespace Admin\Model\Entity;
class ProducerEntity {
	public $producer_id;
	public $name;
	public $describe;
	public function exchangeArray($data)
	{
			$this->producer_id  = (!empty($data['producer_id'])) ? $data['producer_id'] : null;
			$this->name = (!empty($data['name'])) ? $data['name'] : null;
			$this->describe = (!empty($data['describe'])) ? $data['describe'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>