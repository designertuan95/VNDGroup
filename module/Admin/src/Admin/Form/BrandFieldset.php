<?php 
namespace Admin\Form;

 use Admin\Entity\Brand;
 use Zend\Form\Fieldset;
 use Zend\InputFilter\InputFilterProviderInterface;
 use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

 class BrandFieldset extends Fieldset implements InputFilterProviderInterface
 {
     public function __construct()
     {
         parent::__construct('brand');

         $this
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Brand())
         ;

         $this->add(array(
             'name' => 'lastname',
             'options' => array(
                 'label' => 'Name of the brand',
             ),
             'attributes' => array(
                 'required' => 'required',
             ),
         ));

         $this->add(array(
             'name' => 'firstname',
             'type' => 'text',
             'options' => array(
                 'label' => 'Website of the brand',
             ),
             'attributes' => array(
                 'required' => 'required',
             ),
         ));
     }

     /**
      * @return array
      */
     public function getInputFilterSpecification()
     {
         return array(
             'name' => array(
                 'required' => true,
             ),
         );
     }
 }
?>