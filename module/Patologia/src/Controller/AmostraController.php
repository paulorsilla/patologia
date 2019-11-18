<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Amostra;
//use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
//use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
//use Zend\Paginator\Paginator;
use Patologia\Form\AmostraForm;

class AmostraController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Object Manager
     */
    private $objectManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    public function __construct($entityManager, $objectManager) {
        $this->entityManager = $entityManager;
        $this->objectManager = $objectManager;
    }

    public function indexAction() {
        $repo = $this->entityManager->getRepository(Amostra::class);
        $page = $this->params()->fromQuery('page', 1);
        $numeroLaboratorio = $this->params()->fromQuery('numeroLaboratorio', null);
        $search['numeroLaboratorio'] = $numeroLaboratorio;
//        $search = $this->params()->fromPost();
        $paginator = $repo->getPaginator($page, $search);

        return new ViewModel([
            'amostras' => $paginator,
            'status' => ["1" => "Análise não iniciada", "2" => "Em análise", "3" => "Análise encerrada"],
            'search' => $search
        ]);	
    }

    /**
     * Action para salvar um novo registro
     */
    public function saveAction() {
        
        $id = $this->params()->fromRoute('id', null);

        //Cria o formulário
        $form = new AmostraForm($this->objectManager);

        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                
                $data = $form->getData();
                $repo = $this->entityManager->getRepository(Amostra::class);
                $repo->incluir_ou_editar($data, $id);
//                $this->amostraManager->save($data);
                return $this->redirect()->toRoute('patologia/amostra', ['action' => 'index']);
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('patologia/amostra');
        }
        
        $request = $this->getRequest();
        $repo = $this->entityManager->getRepository(Amostra::class);
        $amostra = $repo->find($id);

        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                //$id = (int) $request->getPost('id');
                $repo->delete($amostra);
            }
            // Redireciona para a lista de registros cadastrados
            return $this->redirect()->toRoute('patologia/amostra');
        }

        return new ViewModel([
            'amostra' => $amostra,
        ]);
    }
}
