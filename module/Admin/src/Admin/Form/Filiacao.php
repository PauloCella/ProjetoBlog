<?php
 
 namespace Admin\form;

 use  \Zend\Form\Form as Form;
 use \Zend\Form\Element;

 class Interesse extends Form
 {
 	public function __construct()
 	{
 		parent:: __construct('Filiacao');
 		$this->setAttribute('action', '');
 		$this->setAttribute('method', 'POST');

		$this->add(array(
                     'name' => 'id',
                       'type' => 'hidden',
                       
               ));
			

  		$this->add(array(
                     'name' => 'desc_pai',
                       'type' => 'text',
                       'options' => array(
                               'label' => 'Pai:',                                
                       ),
               ));
                $this->add(array(
                     'name' => 'desc_mae',
                       'type' => 'text',
                       'options' => array(
                               'label' => 'Mae:',                                
                       ),
               ));

		$this->add(array(
			'name' => 'submit',
			'type' => 'submit',
			'attributes' => array(
			'value' => 'Salvar'
			)
		)); 
 	}
 }
 ?>
