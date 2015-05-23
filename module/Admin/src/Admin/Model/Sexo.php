<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
* @ORM\Entity
* @ORM\Table (name = "sexo")
*
* @author Cezar Junior de Souza <cezar08@unochapeco.edu.br>
* #categoy Admin
* @package Model
*/

class Sexo
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
	protected $desc_sexo;

	/**
	* @return string
	*/
	public function getDescSexo()
	{
		return $this->desc_sexo;
	}

	/**
	* @param string $desc_sexo
	*/
	public function setDescSexo($desc_sexo)
	{
		$this->desc_sexo = $desc_sexo;
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
			'name' => 'desc_sexo',
			'required' => true,
			'validators' => array(
				array(
					'name' => 'NotEmpty',
					'options' => array('message' => 'O campo Sexo não pode estar vazio')
					),
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 3,
						'max' => 255,
						'message' => 'O campo Sexo deve ter mais que 3 caracteres e menos que 255',
						),
					),
				),
			'filters' => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
				array('name' => 'StringToUpper',
					'options' => array('encoding' => 'UTF-8')
					),
				),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}

?>