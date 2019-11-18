<?php

namespace Patologia\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\Criteria;

/**
* Formulário utilizado para selecionar amostra e visualizar o resultado de sua análise
*/

class ResultadoForm extends Form
{
	
	protected $objectManager;
	
	/**
	 * Construtor
	 */	
	public function __construct($objectManager)
	{
		//Determina o nome do formulário
		parent::__construct('resultado-form');
		
		$this->objectManager = $objectManager;
		
		//Define o método POST para envio do formulário
		$this->setAttribute('method', 'post');
		
		$this->addElements();
		$this->addInputFilter();
		
	}
	
	public function setObjectManager(ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}
	
	public function getObjectManager() {
		return $this->objectManager;
	}
	
	protected function addElements()
	{
		//Adiciona o campo "numeroLaboratorio"
		$this->add([
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'name' => 'numeroLaboratorio',
				'attributes' => [
						'id' => 'numeroLaboratorio'
				],
				'options' => [
						'label' => 'Amostra (Número do Laboratório)',
						'object_manager' => $this->getObjectManager(),
						'target_class' => 'Patologia\Entity\Amostra',
						'property' => 'numeroLaboratorio',
						'display_empty_item' => true,
						'find_method' => [
								'name' => 'matching',
								'params' => [
										'criteria' => Criteria::create()->where(Criteria::expr()->eq('status', 3)),
										'orderBy' => ['numeroLaboratorio' => 'ASC']
								]
						]
				]
		]);
		
		$this->add([
			'type' => 'submit',
			'name' => 'submit',
			'attributes' => [
					'value' => 'Salvar',
					'id' => 'submitbutton',
			]
		]);
	}
	
	private function addInputFilter()
	{
		$inputFilter = new InputFilter();
		$this->setInputFilter($inputFilter);
	}
}