<?php

namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\ResultadoManager;
use Application\Controller\ResultadoController;

/**
* Factory para instanciar ResultadoController
*/

class ResultadoControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		$entityManager = $container->get('doctrine.entitymanager.orm_default');
		$resultadoManager = $container->get(ResultadoManager::class);
		$objectManager = $container->get('Doctrine\ORM\EntityManager');
		return new ResultadoController($entityManager, $resultadoManager, $objectManager);
	}
}