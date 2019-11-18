<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Patologia\Form\EspecieForm;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Especie;

class EspecieController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function indexAction() {
        $repo = $this->entityManager->getRepository(Especie::class);
        $page = $this->params()->fromQuery('page', 1);
        $search = $this->params()->fromPost();
        $paginator = $repo->getPaginator($page, $search);

        return new ViewModel([
            'especies' => $paginator,
        ]);
    }

    /**
     * Action para salvar um novo registro
     */
    public function saveAction() {
        $id = $this->params()->fromRoute('id', null);
        
        //Cria o formulário
        $form = new EspecieForm();

        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repo = $this->entityManager->getRepository(Especie::class);
                $repo->incluir_ou_editar($data,$id);
                return $this->redirect()->toRoute('patologia/especie', ['action' => 'save']);
            }
        } else {
            if ( !empty($id)){
                $repo = $this->entityManager->getRepository(Especie::class);
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

//    public function editAction() {
//        $form = new EspecieForm();
//        $id = $this->params()->fromRoute('id', -1);
//        $especie = $this->entityManager->getRepository(Especie::class)->findOneById($id);
//        if ($especie == null) {
//            $this->getResponse()->setStatusCode(404);
//            return;
//        }
//        if ($this->getRequest()->isPost()) {
//            $data = $this->params()->fromPost();
//            $form->setData($data);
//            if ($form->isValid()) {
//                $data = $form->getData();
//                $this->especieManager->update($especie, $data);
//                return $this->redirect()->toRoute('application/especie');
//            }
//        } else {
//            $form->bind($especie);
//            $form->get('submit')->setAttribute('value', 'Editar');
//        }
//        return new ViewModel([
//            'form' => $form,
//            'especie' => $especie
//        ]);
//    }

    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('patologia/especie');
        }
        
        $request = $this->getRequest();
        $repo = $this->entityManager->getRepository(Especie::class);
        $especie = $repo->find($id);

        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                //$id = (int) $request->getPost('id');
                $repo->delete($especie);
            }
            // Redireciona para a lista de registros cadastrados
            return $this->redirect()->toRoute('patologia/especie');
        }

        return new ViewModel([
            'especie' => $especie,
        ]);
    }

}
