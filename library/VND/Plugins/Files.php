<?php
namespace VND\Plugins;
class Files
{
   public $result = FALSE;
   public static function deleteFile($path)
   {
      if(file_exists($path)){
      	if(unlink($path)) return TRUE;
      }
   }
}
?>