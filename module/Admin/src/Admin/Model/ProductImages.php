<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use VND\Model\Model;
use Zend\Db\Sql\Select;
class ProductImages extends Model{
	/*
	Khi update sản phẩm cần xóa ảnh trong album trước khi update và update lại hình ảnh. Nếu vẫn giữ nguyên ảnh cũ thì không cần xóa ảnh
	*/
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}

	public function InsertItem($data,$id = null){
		// Thực hiện xóa toàn bộ ảnh cũ .
		// Thêm lại ảnh mới
		$result = array();
		$arrParams = array('id' => 0, 'column' => 'product_id');
		// Thực hiện xóa toàn bộ id cũ
		parent::delete($column = 'product_id','product_images',$id);
		if(is_array($data['image']) && count($data['image']) > 0){
			foreach($data['image'] as $idImage => $image){
				$arrData = array(
					'product_id' => $data['product_id'],
					'image' => $image
				);
				#print_r($arrData);
				$result[] = parent::saveItem($arrData,$arrParams);
			}
		}
		return $result;
	}
	public function getImagesById($idProduct = 0){
		$rowset = $this->tableGateway->select(function(Select $select) use($idProduct){
			$select->where(array('product_id' => $idProduct));
			#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select).'<br/>';
		});
        return $rowset->toArray();
	}
	public function getImageByIdImage($idImage){
		return parent::getItemById($idImage,'product_image_id');
	}
	public function deleteImages($idImage,$idProduct)
	{
		$image = $this->getImageByIdImage($idImage);
		$this->tableGateway->delete(array('product_id' => (int) $idProduct,'product_image_id' => $idImage));
		return $image;
	}

	public function deleteImagesByIdProduct($idProduct){
		$this->deleteImagesDestroy($idProduct);
		parent::delete($column = 'product_id','product_images',$idProduct);
	}

	public function deleteImagesDestroy($id){
		// Lấy toàn bộ ảnh sản phẩm có trong bảng product_images
		$allImages = $this->getImagesById($id);
		foreach($allImages as $image){
			$fileInfo = APPLICATION_PATH .$image['image'];
			// Filte thumb
			$filetThumb = str_replace("/public/media/products/images/","/public/media/products/thumb/small/100.100_",$fileInfo);
			// Xóa ảnh gốc
			\VND\Plugins\Files::deleteFile($fileInfo);
			// Xóa ảnh thumb
			\VND\Plugins\Files::deleteFile($filetThumb);
		}
		
	}
}