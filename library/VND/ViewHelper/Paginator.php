<?php
namespace VND\ViewHelper;
class Paginator
{
	public static function createPaginator($arrParams = null)
	{
		$adapter  = new \Zend\Paginator\Adapter\Null($arrParams['countItem']);
		$Paginator = new \Zend\Paginator\Paginator($adapter);
		// Setting Paginator
		$Paginator->setCurrentPageNumber($arrParams['CurrentPageNumber']);
		$Paginator->setItemCountPerPage($arrParams['ItemCountPerPage']);
		$Paginator->setPageRange($arrParams['PageRange']);
		return $Paginator;
	}
}
?>