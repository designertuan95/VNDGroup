<?php

namespace VND\ViewHelper\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElementErrors;

class ELementError extends FormElementErrors {
	public function __invoke(ElementInterface $element = null) {
		$message = $element->getMessages ();
		if (empty ( $message ))
			return '';
		return sprintf('<small class="help-block error">The confirm password is required and cannot be empty</small>'
				,current($message));
	}
}