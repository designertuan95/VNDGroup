<?php
namespace Admin\Model;
use VND\Model\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Model\Entity\ProductEntity;
class Product extends Model 
implements ServiceLocatorAwareInterface
{
	protected $tableGateway;
	public $sqlSelect;
	protected $adapter;
	protected $serviceLocator;
	public $data;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function countItem()
	{
		return $this->tableGateway->select()->count();
	}
	public function listItem($option = array('type' => 'public'),$arrParams = null)
	{
		$resultSet = '';
		if($option['type'] == 'Admin')
		{
			$resultSet	= $this->tableGateway->select(function(Select $select) use($arrParams){
				$select->columns(array('product_id','product_name','data_added','price','image'));
				$select->join(
					array('qty' => 'warehouse'),
					'qty.product_product_id = product.product_id',
					array('quantity'),
					$select::JOIN_LEFT);
				$select->join(
					array('ncc' => 'producer'),
					'ncc.producer_id = product.producer_id',
					array('producer_name' => 'name'),
					$select::JOIN_LEFT);
				$filterData = $arrParams['filterData'];
				if($filterData){
					// Tìm kiếm theo từ khóa
					if(!empty($filterData['Query'])){
						$select->where(new \Zend\Db\Sql\Predicate\Like('product.product_name','%'.$filterData['Query'].'%'));
					}
					// Filter Status
					if(isset($filterData['filter_status'])){
						$select->where(array('product.status' => $filterData['filter_status']));
					}
					// Filter Category
					if(!empty($filterData['filter_collection'])){
						$select->join(
							array('pc' => 'product_category'),
							'pc.product_id = product.product_id',
							array(),
							$select::JOIN_LEFT);
							$select->where(array('pc.category_id' => $filterData['filter_collection']));
					}
					// Filter Group Product
					if(!empty($filterData['filter_group_product'])){
						$select->join(
								array('gp' => 'group_product'),
								'gp.product_id = product.product_id',
								array(),
								$select::JOIN_LEFT);
						$select->where(array('gp.group_display_id' => $filterData['filter_group_product']));
					}
					// Filter Producer
					if(isset($filterData['filter_vendor'])){
						$select->where(array('product.producer_id' => $filterData['filter_vendor']));
					}
				
				}
				if(!empty($arrParams['page']) 
					&& isset($arrParams['page']['ItemCountPerPage']) 
					&& $arrParams['page']['CurrentPageNumber']){
					$select->limit($arrParams['page']['ItemCountPerPage']); // Số bài muốn lấy
					// Vị trí bắt đầu lấy
					$select->offset(($arrParams['page']['CurrentPageNumber']-1) *$arrParams['page']['ItemCountPerPage']);
				}
				$select->order('data_added DESC','date_modified DESC');
				#echo $this->sqlSelect = $this->tableGateway->getSql()->getSqlstringForSqlObject($select).'<br/>';
			});
		}

		return $resultSet;
	}
	public function insertItem($objData){
		// Insert Item 
		
		$dataInsert = $this->setDataSave($objData);
		// # 01. Insert Product
		$arrParams = array('id' => 0, 'column' => 'product_id');
		$idProduct =  parent::saveItem($dataInsert['product'],$arrParams);
		// Set Data Table Group_product
		if($idProduct > 0){
		// If the more successful products
			$dataInsert['group_product']['product_id'] = $idProduct;
			$GroupProductObj = $this->getServiceLocator()->get('Admin\Model\GroupProductTable');
			/// Perform additional group
			$GroupProductObj->InsertItem($dataInsert['group_product']);
			# 02. Insert Warehouse
			$dataInsert['warehouse']['product_product_id'] = $idProduct;
			$WarehouseObj = $this->getServiceLocator()->get('Admin\Model\WarehouseTable');
			$WarehouseObj->InsertItem($dataInsert['warehouse']);
			# 03. Insert Product_category
			$dataInsert['product_category']['product_id'] = $idProduct;
			$ProductCategoryObj = $this->getServiceLocator()->get('Admin\Model\ProductCategoryTable');
			$ProductCategoryObj->InsertItem($dataInsert['product_category']);

			# 04 Insert Filter 
			$dataInsert['filter']['product_id'] = $idProduct;
			$FilterObj = $this->getServiceLocator()->get('Admin\Model\ProductFilterTable');
			$FilterObj->InsertItem($dataInsert['filter']);
			
			# 05 Insert Album Images
			$dataInsert['albumImages']['product_id'] = $idProduct;
			$FilterObj = $this->getServiceLocator()->get('Admin\Model\ProductImagesTable');
			$FilterObj->InsertItem($dataInsert['albumImages']);
		}
		return $idProduct;
	}
	public function editItem($objData,$id)
	{
		// Insert Item 
		$dataInsert = $this->setDataSave($objData);
		
		// # 01. Insert Product
		$arrParams = array('id' => $id, 'column' => 'product_id');
		$dataInsert['product']['product_id'] = $id;
		$result = parent::saveItem($dataInsert['product'],$arrParams);
		
		// Set Data Table Group_product
		if($id){
		//If the more successful products
			# 02 . Insert Group Product
			$dataInsert['group_product']['product_id'] = $id;
			$GroupProductObj = $this->getServiceLocator()->get('Admin\Model\GroupProductTable');
			$GroupProductObj->InsertItem($dataInsert['group_product'],$id);
			# 03. Insert Product_category
			$dataInsert['product_category']['product_id'] = $id;
			$ProductCategoryObj = $this->getServiceLocator()->get('Admin\Model\ProductCategoryTable');
			$ProductCategoryObj->InsertItem($dataInsert['product_category'],$id);
			# 04 Insert Filter 
			$dataInsert['filter']['product_id'] = $id;
			$FilterObj = $this->getServiceLocator()->get('Admin\Model\ProductFilterTable');
			$FilterObj->InsertItem($dataInsert['filter'],$id);
			# 05 Insert Album Images
			$dataInsert['albumImages']['product_id'] = $id;
			$FilterObj = $this->getServiceLocator()->get('Admin\Model\ProductImagesTable');
			$FilterObj->InsertItem($dataInsert['albumImages'],$id);
		}
		return $result;
	}
	public function setDataSave($objData){
		$dataInsert = array(
			'product' => array(
				'product_id' 			=> $objData->product_id,
				'product_name' 			=> $objData->product_name,
				'model' 				=> $objData->model,
				'SKU' 					=> $objData->SKU,
				'price' 				=> $objData->price,
				'listed_price' 			=> $objData->listed_price,
				'image' 				=> $objData->image,
				'guarantee' 			=> $objData->guarantee,
				'viewed' 				=> $objData->viewed,
				'status' 				=> $objData->status,
				'describe' 				=> $objData->describe,
				'alias' 				=> $objData->alias,
				'meta_title' 			=> $objData->meta_title,
				'meta_description' 		=> $objData->meta_description,
				'meta_keyword' 			=> $objData->meta_keyword,
				'data_added' 			=> $objData->data_added,
				'date_modified' 		=> $objData->date_modified,
				'producer_id' 			=> $objData->producer_id,
			),
			'group_product' => array(
				'group_display_id' => $objData->group_product
			),
			'warehouse' => array(
				'inventory_policy'  => $objData->inventory_policy,
				'quantity'			=> $objData->quantity 
			),
			'product_category'	=> array(
				'category_id'	=> $objData->category
			),
			'filter'			=> array(
				'filter_id'		=> $objData->filter_id
			),
			'albumImages' => array(
				'image'		 => $objData->albumImages,
				'sort_order' => 0
			)
		);
		return $dataInsert;
	}
	public function getItemById($id){
		$id  = (int) $id;
        $rowset = $this->tableGateway->select(function(Select $select) use($id){
        	$select->where(array('product.product_id' => $id));
        	$select->join(
        		array('warehouse' => 'warehouse'),
        		'warehouse.product_product_id =  product.product_id',
        		array('quantity','inventory_policy')
    		);
        	$select->join(
        		array('gp' => 'group_product'),
        		'gp.product_id =  product.product_id',
        		array('group_product' => new \Zend\Db\Sql\Expression('GROUP_CONCAT(DISTINCT group_display_id)')),
        		$select::JOIN_LEFT 
    		);
    		$select->join(
        		array('cat' => 'product_category'),
        		'cat.product_id =  product.product_id',
        		array('category' => new \Zend\Db\Sql\Expression('GROUP_CONCAT(DISTINCT category_id)')),
        		$select::JOIN_LEFT 
    		);
    		$select->join(
        		array('pf' => 'product_filter'),
        		'pf.product_id =  product.product_id',
        		array('filter_id' => new \Zend\Db\Sql\Expression('GROUP_CONCAT(DISTINCT filter_id)')),
        		$select::JOIN_LEFT 
    		);
        	#echo $this->sqlSelect = $this->tableGateway->getSql()->getSqlstringForSqlObject($select).'<br/>';
        });
        $row = $rowset->current();
        return $row;
	}

	public function getAlbumImages($idProduct)
	{
		$objImages = $this->getServiceLocator()->get('Admin\Model\ProductImagesTable');
		return $objImages->getImagesById($idProduct);
	}

	public function deleteItem($id)
	{
		parent::delete($column = 'product_id',$table = 'product',$id);
		# 02. Delete Group Product
		$GroupProductObj = $this->getServiceLocator()->get('Admin\Model\GroupProductTable');
		$GroupProductObj->deleteItem($id);
		# 03. Delete Product_category
		$ProductCategoryObj = $this->getServiceLocator()->get('Admin\Model\ProductCategoryTable');
		$ProductCategoryObj->deleteItem($id);
		# 04 Delete Filter 
		$FilterObj = $this->getServiceLocator()->get('Admin\Model\ProductFilterTable');
		$FilterObj->deleteItem($id);
		# 04 Delete Warehouse
		$FilterObj = $this->getServiceLocator()->get('Admin\Model\WarehouseTable');
		$FilterObj->deleteItem($id);
		# 05 Delete Album Images
		$ImagesObj = $this->getServiceLocator()->get('Admin\Model\ProductImagesTable');
		$ImagesObj->deleteImagesByIdProduct($id);
		$ImagesObj->deleteImagesDestroy($id);
		
	}
	
}
?>