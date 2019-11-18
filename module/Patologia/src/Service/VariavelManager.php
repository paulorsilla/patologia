<?php
namespace Application\Service;


class VariavelManager
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
	
	public function save()
	{
//		return $this->entityManager->getRepository(Variavel::class)->findAll();
	}
}