<?php
 
 namespace Admin\form;

 use  \Zend\Form\Form as Form;
 use \Zend\Form\Element;

 class Sexo extends Form
 {
 	public function __construct()
 	{
 		parent:: __construct('Sexo');
 		$this->setAttribute('action', '');
 		$this->setAttribute('method', 'POST');


 		$this->add(array(
                     'name' => 'desc_sexo',
                       'type' => 'text',
                       'options' => array(
                               'label' => 'Sexos:',                                
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