<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
* @ORM\Entity
* @ORM\Table (name = "telefone")
*
* @author Paulo José Cella <paulocella@unochapeco.edu.br>
* #categoy Admin
* @package Model
*/

class Telefone
{
	/**
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	* @ORM\Column(type="integer")
	*
	* @var integer
	*/
	protected $id;
	protected $inputFilter;

	/**
	* @ORM\Column (type="string")
	*
	* @var string
	*/
	protected $desc_telefone;

	/**
	* @return string
	*/
	public function getDescTelefone()
	{
		return $this->desc_telefone;
	}

	/**
	* @param string $desc_telefone
	*/
	public function setDescTelefone($desc_telefone)
	{
		$this->desc_telefone = $desc_telefone;
	}

	/**
	* @return int
	*/
	public function getId()
	{
		return $this->id;
	}

	public function getArrayCopy()
	{
	return get_object_vars($this);
	}
	/**
	*
	* @return Zend/InputFilter/InputFilter
	*/
	public function getInputFilter(){
		if (!$this->inputFilter) {

			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			$inputFilter->add($factory->createInput(array(
			'name' => 'id',
			'required' => false,
			'filters' => array(
				array('name' => 'Int'),
				),
			)));
			$inputFilter->add($factory->createInput(array(
			'name' => 'desc_telefone',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'options' => array('message' => 'O campo Telefone não pode estar vazio')
					),
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 8,
						'max' => 30,
						'message' => 'O campo Telefone deve ter mais que 8 caracteres e menos que 30',
						),
					),
				),
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}

?>
