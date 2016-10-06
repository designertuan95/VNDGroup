<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use VND\Model\Model;
class ProductCategory extends Model{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function InsertItem($data,$id = null){
		$result = array();
		$arrParams = array('id' => 0, 'column' => 'product_id');
		$this->deleteItem($id);
		if(is_array($data['category_id']) && count($data['category_id']) > 0){
			foreach($data['category_id'] as $category){
				$arrData = array(
					'product_id' => $data['product_id'],
					'category_id' => $category
				);
				$result[] = parent::saveItem($arrData,$arrParams);
			}
		}
		return $result;
	}

	public function deleteItem($id){
		parent::delete($column = 'product_id','product_category',$id);
	}

}
?>