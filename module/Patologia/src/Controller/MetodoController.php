<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Patologia\Form\MetodoForm;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Metodo;

class MetodoController extends AbstractActionController
{
	/**
	 * Entity Manager
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;

        private $objectManager;
	
	/**
	 * Construtor da classe, utilizado para injetar as dependências
	 */
	public function __construct($entityManager, $objectManager)
	{
            $this->entityManager = $entityManager;
            $this->objectManager = $objectManager;
	}
	
	public function indexAction()
	{
            $repo = $this->entityManager->getRepository(Metodo::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);

            return new ViewModel([
                'metodos' => $paginator
            ]);
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            //Cria o formulário
            $form = new MetodoForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Metodo::class);
                    $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('patologia/metodo', ['action' => 'save']);
                }
            } else {
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Metodo::class);
                    $row = $repo->find($id);
                    if ( !empty($row)){
                        $form->setData($row->toArray());
                    }
                }
            }
            return new ViewModel([
                'form' => $form
            ]);
	}
	
	public function deleteAction()
	{
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('patologia/metodo');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Metodo::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $metodo = $repo->find($id);
                    $repo->delete($metodo);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('patologia/metodo');
            }
            $metodo = $repo->find($id);

            return new ViewModel([
                'metodo' => $metodo,
            ]);
	}
}
