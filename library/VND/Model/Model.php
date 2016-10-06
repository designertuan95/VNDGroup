<?php
namespace VND\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class Model implements ServiceLocatorAwareInterface
{
    protected $tableGateway;	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
	public function delete($column = '',$table,$id = 0,$option = array())
    {
        // Delete Item 
        if(!is_array($id)){
            $this->tableGateway->delete(array($column => (int) $id));
        }elseif(is_array($id) && count($id) > 0){
            $deleteObj = new \Zend\Db\Sql\Delete($table);
            $deleteObj->where(
                new \Zend\Db\Sql\Predicate\In($column,$id)
            );
            $this->tableGateway->deleteWith($deleteObj); 
        }elseif($option['task'] == 'deleteAll'){
            $this->tableGateway->delete();
        }
    }
    public function countItem($option = null){
        return $this->tableGateway->select()->count();
    }
    public function saveItem($arrData = null,$arrParams = null)
    {   
        $id = (int) $arrParams['id'];
        
        $result = '';
        if($id == 0){
            // Insert Action
            $this->tableGateway->insert($arrData);
            $result = $this->tableGateway->getLastInsertValue();
        }else{
            // Update Action
            if ($this->getItemById($id,$arrParams['column'])) {
            	$this->tableGateway->update($arrData, array($arrParams['column'] => $id));
            	return  TRUE;
            } else {
               $result =  \Exception('Album id does not exist');
            }
        }
        
        return $result;
    }
	public function updateColumn($arrData = null,$arrParams)
	{
// 		$arrParams = array(
// 				'id' => $id,
// 				'column' => 'column',
// 		);
	print_r($arrData);
	print_r($arrParams);
		$arrParams = array('id' => $arrParams['id'], 'column' => $arrParams['column']);
		$this->saveItem($arrData,$arrParams);
	}
    public function getItemById($id,$column)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array($column => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
}
?>