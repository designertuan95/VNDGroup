<?php
namespace Upload;
include '/class.upload.php';
use upload;
class UploadImage{
	public $result;
	public static function uploadImage($file,$path,$width = 100,$height = 100)
	{
		$upload = new upload($file);
		if ($upload->uploaded) {
			// Upload file gốc
			// Thực hiện upload lại để lấy file thumb
			
			if($width != null && $height != null){
				// Upload ảnh gốc
				$upload->image_resize = true;
				$upload->image_x = $width;
				$upload->image_y = $height;
				$upload->file_name_body_pre = "{$width}.{$height}_";
			}
			#echo $width . 'Height' . $height;
			// Thực hiện rename lại theo url bài viết để chuẩn seo
			// Thực hiện thêm tên vào sau
			// Lưu ảnh đại diện hiện ngoài trang chủ
			
			$upload->Process($path);
			if ($upload->processed) {
				// Nếu upload thành công thì trả về tên của ảnh
				return $upload->file_dst_name;
			}else{
				return false;
			}
		}else{
			return  false;
		}
	}

	public static function uploadImages($files,$path,$width = 300,$height = 300)
	{
		$result = array();
		foreach($files as $file){
			$result[] = self::uploadImage($file,$path,$width,$height);
		}
		return $result;
	}
}
?>