<?php
namespace Admin\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
* @ORM\Entity
* @ORM\Table (name = "filiacao")
*
* @author Paulo Cella <paulocella@unochapeco.edu.br>
* #categoy Admin
* @package Model
*/

class Filiacao
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
	protected $desc_pai;
        
        /**
	* @ORM\Column (type="string")
	*
	* @var string
	*/
	protected $desc_mae;

	/**
	* @return string
	*/
	public function getDescPai()
	{
		return $this->desc_sexo;
	}

	/**
	* @param string $desc_sexo
	*/
	public function setDescPai($desc_pai)
	{
		$this->desc_pai = $desc_pai;
	}
        /**
	* @return string
	*/
	public function getDescMae()
	{
		return $this->desc_mae;
	}

	/**
	* @param string $desc_mae
	*/
	public function setDescMae($desc_mae)
	{
		$this->desc_mae = $desc_mae;
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
			'name' => 'desc_pai',
			'required' => false,
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 2,
						'max' => 100,
						'message' => 'O campo Pai deve ter mais que 3 caracteres e menos que 100',
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
                        
                        $inputFilter->add($factory->createInput(array(
			'name' => 'desc_mae',
			'required' => false,
			'validators' => array(
				array(
					'name' => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min' => 2,
						'max' => 100,
						'message' => 'O campo Mae deve ter mais que 3 caracteres e menos que 100',
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