<?php
namespace Application\Service;

class ResultadoManager
{
	/**
	 * Doctrine entity manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	
	private $entityManager;
	
	public function __construct($entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	public function find()
	{
	}

}