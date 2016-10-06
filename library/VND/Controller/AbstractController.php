<?php
namespace VND\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class AbstractController extends AbstractActionController
{
	protected $_option;
	protected $_tableObj;
	protected $_formObj;
	protected $_params;
	protected $_general = array();
		
	public function getTable(){
		return (!$this->_tableObj) ? $this->getServiceLocator()->get($this->_option['tableName']) : TRUE;
	}
	public function getForm(){
		return $this->getServiceLocator()->get('FormElementManager')->get($this->_option['formName']);
	}
	public function setPluginManager(PluginManager $plugin){
		$eventManager	= $this->getEventManager();
		$eventManager->attach(MvcEvent::EVENT_DISPATCH,array($this,'onInit'),100);
		parent::setPluginManager($plugin);
	}
	public function onInit(MvcEvent $e){
		$routeMatch 	= $e->getRouteMatch();

		// GET MODULE - CONTROLLER - ACTION
		$arrController 	= explode('\\', $routeMatch->getParam('controller'));
		$viewModel		= $e->getApplication()->getMvcEvent()->getViewModel();
		$this->_params	= array(
			'module'		=> $arrController['0'],
			'controller'	=> $arrController['2'],
			'action'		=> $routeMatch->getParam('action'),
		);

		// SET MODULE - CONTROLLER - ACTION FOR VIEW
		$viewModel->module 		= strtolower($this->_params['module']);
		$viewModel->controller 	= strtolower($this->_params['controller']);
		$viewModel->action 		= strtolower($this->_params['action']);
		$this->_general['form_general'] = $this->getServiceLocator()->get('FormElementManager')->get('general');
		// SET _tableObj
		$this->_tableObj 	= $this->getTable();
		$this->_formObj 	= $this->getForm();
	}

	public function redirectAdmin($controller = null,$action = null,$id = null)
	{
		if($id != null && $id > 0){
			return $this->redirect()->toRoute('AdminRoute/default', array(
		        'controller' => $controller,
		        'action' =>  $action,
		        'id'	=> $id,
		    ));
		}
		return $this->redirect()->toRoute('AdminRoute/default', array(
	        'controller' => $controller,
	        'action' =>  $action
	    ));

	}
	public function getId($column)
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if($column != null){
			$request = $this->getRequest();
			if ($request->isPost()){
				$validator = new \Zend\Validator\Digits();
				$error = array ();
				$id = array ();
				$data = $request->getPost();
				// Object to array
				$data = get_object_vars ( $data );
				foreach ($data[$column] as $idItem ) {
					if ($validator->isValid ( $idItem )) {
						$id [] = $idItem;
					} else {
						$error [] = $validator->getMessages ();
					}
				}
			}
		}
		if($id == 0 || count($id) == 0){
			return $this->redirectAdmin('index','index');
		}else{
			return $id;
		}
	}

	public function getQuery()
	{
		// Get Query Search
		return array(
			'type_search' => (int) $this->params()->fromQuery('page', 0),
			'key_search'  => $this->params()->fromQuery('Query','')
		);
	}
}
?>