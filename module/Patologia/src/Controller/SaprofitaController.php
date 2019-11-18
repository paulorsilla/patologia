<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Patologia\Form\SaprofitaForm;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Saprofita;

class SaprofitaController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Saprofita::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);

            return new ViewModel([
                'saprofitas' => $paginator
            ]);
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            //Cria o formulário
            $form = new SaprofitaForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Saprofita::class);
                    $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('patologia/saprofita', ['action' => 'save']);
                }
            } else {
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Saprofita::class);
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
                return $this->redirect()->toRoute('patologia/saprofita');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Saprofita::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $saprofita = $repo->find($id);
                    $repo->delete($saprofita);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('patologia/saprofita');
            }
            $saprofita = $repo->find($id);

            return new ViewModel([
                'saprofita' => $saprofita,
            ]);
	}
}
