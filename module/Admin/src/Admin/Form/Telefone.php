<?php
 
 namespace Admin\form;

 use  \Zend\Form\Form as Form;
 use \Zend\Form\Element;

 class Telefone extends Form
 {
 	public function __construct()
 	{
 		parent:: __construct('Telefone');
 		$this->setAttribute('action', '');
 		$this->setAttribute('method', 'POST');


		$this->add(array(
                     'name' => 'id',
                       'type' => 'hidden'
                       
               ));

 		$this->add(array(
                     'name' => 'desc_telefone',
                       'type' => 'text',
                       'options' => array(
                               'label' => 'Telefones:',                                
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
