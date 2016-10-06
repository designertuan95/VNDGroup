<?php
namespace VND\ViewHelper;
class ImageView
{
	public static function viewAvatar($img = '' ,$url)
	{
		return (empty($img)) ?  URL_TEMPLATE.'/admin/assets/img/no-image-50-50.png' : $url.$img;
	}
}
?>