<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use VND\Model\Model;
class GroupDisplayHome extends Model
{
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function listItem($option = null,$arrData = null)
	{
		if($option['task'] == 'page'){
			$resultSet = $this->tableGateway->select(function (Select $select) use($option,$arrData){
					if(isset($arrData['Query']) && !empty($arrData['Query'])){
						$select->where(
							new \Zend\Db\Sql\Predicate\Like('name','%'.$arrData['Query'].'%')
						);
					}
					$select->limit($arrData['ItemCountPerPage']); // Số bài muốn lấy
					// Vị trí bắt đầu lấy
					$select->offset( ($arrData['CurrentPageNumber']-1) * $arrData['ItemCountPerPage']);
					$select->order('sort_order ASC group_display_id DESC');
				#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}
		return $resultSet;
	}
	public function saveItem($objData = null,$id = null)
	{	
		$arrData = array(
			'name' 	   => $objData->name,
			'describe' => $objData->describe,
			'sort_order' => $objData->sort_order,
			'status'   => $objData->status,
		);
		$arrParams = array('id' => $id, 'column' => 'group_display_id');
		return parent::saveItem($arrData,$arrParams);
	}
	public function deleteItem($id = 0,$option = array('task' => 'item'))
	{
		parent::delete(
			$column = 'group_display_id',
			$table = 'group_display',
			$id,
			$option
		);
	}
	public function itemSelectBox()
	{
		$items = $this->tableGateway->select(function(Select $select){
			$select->columns(array('name','group_display_id'));
		});
		$result = array();
		foreach($items as $item)
		{
			$result[$item->group_display_id] = $item->name;
		}
		return $result;
	}
}
