<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Patologia\Form\DeterminacaoForm;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Determinacao;

class DeterminacaoController extends AbstractActionController
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
            $repo = $this->entityManager->getRepository(Determinacao::class);
            $page = $this->params()->fromQuery('page', 1);
            $search = $this->params()->fromPost();
            $paginator = $repo->getPaginator($page, $search);
            $tipos = ['1' => "Patógeno (fungo)",
                      '2' => "Outras"];

            return new ViewModel([
                'determinacoes' => $paginator,
                'tipos' => $tipos
            ]);	
	}
	
	/**
	 * Action para salvar um novo registro
	 */
	public function saveAction()
	{
            $id = $this->params()->fromRoute('id', null);
            //Cria o formulário
            $form = new DeterminacaoForm($this->objectManager);

            //Verifica se a requisição utiliza o método POST
            if ($this->getRequest()->isPost()) {

                //Recebe os dados via POST
                $data = $this->params()->fromPost();

                //Preenche o form com os dados recebidos e o valida
                $form->setData($data);
                if ($form->isValid()) {
                    $data = $form->getData();
                    $repo = $this->entityManager->getRepository(Determinacao::class);
                    $repo->incluir_ou_editar($data, $id);
                    return $this->redirect()->toRoute('patologia/determinacao', ['action' => 'save']);
                }
            } else {
                if ( !empty($id)){
                    $repo = $this->entityManager->getRepository(Determinacao::class);
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
                return $this->redirect()->toRoute('patologia/determinacao');
            }
            $request = $this->getRequest();
            $repo = $this->entityManager->getRepository(Determinacao::class);

            if ($request->isPost()) {
                $del = $request->getPost('del', 'Não');
                if ($del == 'Sim') {
                    $determinacao = $repo->find($id);
                    $repo->delete($determinacao);
                }
                // Redireciona para a lista de registros cadastrados
                return $this->redirect()->toRoute('patologia/determinacao');
            }
            $determinacao = $repo->find($id);

            return new ViewModel([
                'determinacao' => $determinacao,
            ]);
	}
}
