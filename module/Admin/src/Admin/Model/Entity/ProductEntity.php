<?php
namespace Admin\Model\Entity;
class ProductEntity {
	public $product_id;
	public $product_name;
	public $model;
	public $SKU;
	public $producer_id;
	public $Barcode;
	public $producer_name;
	public $guarantee;
	public $viewed;
	public $status;
	public $describe;
	public $alias;
	public $meta_title;
	public $meta_description;
	public $meta_keyword;
	public $data_added;
	public $date_modified;
	// Product_images
	public $product_image_id;
	public $image;
	public $sort_order;
	// Product_detail
	public $price;
	public $listed_price;
	// Attribute 
	public $product_attribute_id;
	public $attribute_id;
	public $value;
	// Ware House
	public $quantity;
	public $inventory_policy;
	// Category
	public $cat_name;

	// Group Display
	public $group_product ;
	public $category;
	public $filter_id;
	public function exchangeArray($data)
	{
		$time = new \Zend\Stdlib\DateTime();
		$this->product_id 		= (!empty($data['product_id'])) ? $data['product_id'] : null;
		$this->product_name 	= (!empty($data['product_name'])) ? $data['product_name'] : null;
		$this->Barcode 			= (!empty($data['Barcode'])) ? $data['Barcode'] : null;
		$this->model 			= (!empty($data['model'])) ? $data['model'] : null;

		$this->SKU 				= (!empty($data['SKU'])) ? $data['SKU'] : null;

		$this->producer_id 		= (!empty($data['producer_id'])) ? $data['producer_id'] : null;
		$this->producer_name 	= (!empty($data['producer_name'])) ? $data['producer_name'] : null;

		$this->guarantee = (!empty($data['guarantee'])) ? $data['guarantee'] : null;
		$this->viewed = (!empty($data['viewed'])) ? $data['viewed'] : 0;
		$this->status = (!empty($data['status'])) ? $data['status'] : 1;
		$this->describe = (!empty($data['describe'])) ? $data['describe'] : null;
		
		$this->alias = (!empty($data['alias'])) ? $data['alias'] : null;
		$this->meta_title = (!empty($data['meta_title'])) ? $data['meta_title'] : null;
		$this->meta_description = (!empty($data['meta_description'])) ? $data['meta_description'] : null;
		$this->meta_keyword = (!empty($data['meta_keyword'])) ? $data['meta_keyword'] : null;
		$this->data_added = (!empty($data['data_added'])) ? $data['data_added'] : date('Y-m-d H:i:s',$time->getTimestamp());
		$this->date_modified = (!empty($data['date_modified'])) ? $data['date_modified'] : date('Y-m-d H:i:s',$time->getTimestamp());
		// Product_images
		$this->product_image_id = (!empty($data['product_image_id'])) ? $data['product_image_id'] : null;
		$this->image = (!empty($data['image'])) ? $data['image'] : null;
		$this->sort_order = (!empty($data['sort_order'])) ? $data['sort_order'] : null;
		// Product_detail
		$this->price = (!empty($data['price'])) ? $data['price'] : null;
		$this->listed_price = (!empty($data['listed_price'])) ? $data['listed_price'] : null;

		// Attribute 
		$this->product_attribute_id = (!empty($data['product_attribute_id'])) ? $data['product_attribute_id'] : null;
		$this->attribute_id = (!empty($data['attribute_id'])) ? $data['attribute_id'] : null;
		$this->value = (!empty($data['value'])) ? $data['value'] : null;

		// Warehoust 
		$this->inventory_policy = (!empty($data['inventory_policy'])) ? $data['inventory_policy'] : 0;
		$this->quantity = (!empty($data['quantity'])) ? $data['quantity'] : 0;
		// Warehoust 
		$this->cat_name = (!empty($data['cat_name'])) ? $data['cat_name'] : null;
		//Group
		// Để lấy group_display_id thì cần join tới bảng group_product và ở phương thức GetItemById đã join
		// Và thực hiện group_concat id lại
		$this->category =  (!empty($data['category'])) ?  $this->escapeMultiData($data['category']) : null;
		$this->group_product = (!empty($data['group_product'])) ?  $this->escapeMultiData($data['group_product']) : null;
		$this->filter_id = (!empty($data['filter_id'])) ?  $this->escapeMultiData($data['filter_id']) : null;
		$this->albumImages = (!empty($data['albumImages'])) ? $data['albumImages'] : null;
		
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function escapeMultiData($data)
    {
		if(is_array($data)){
			return $data;
		}elseif(is_string($data)){
			return  explode(',',$data);
		}	
    }

}
?>