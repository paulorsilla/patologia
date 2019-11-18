<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Patologia\Form\ResultadoForm;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Amostra;
use Patologia\Entity\Resultado;

class ResultadoController extends AbstractActionController {

    /**
     * Entity Manager
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Object Manager
     * @var 
     */
    private $objectManager;

    /**
     * Construtor da classe, utilizado para injetar as dependências no controller
     */
    public function __construct($entityManager, $objectManager) {
        $this->entityManager = $entityManager;
        $this->objectManager = $objectManager;
    }

    public function findAction() {
        $form = new ResultadoForm($this->objectManager);
        $amostra = null;

        if ($this->getRequest()->isPost()) {
            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                return $this->redirect()->toRoute('patologia/resultado', ['action' => 'view', 'id' => $data['numeroLaboratorio']]);
            }
        }
        return new ViewModel([
            'form' => $form,
            'amostra' => $amostra
        ]);
    }

    public function viewAction() {
        $amostra_id = $this->params()->fromRoute('id', 0);
        $amostra = $this->entityManager->find(Amostra::class, $amostra_id);
        $resultados = [];
        $totais = [];
        foreach ($amostra->getRepeticoes() as $repeticao) {
            $res = $this->entityManager->getRepository(Resultado::class)->findBy(['repeticao' => $repeticao]);
            foreach ($res as $r) {
                $resultados[$repeticao->getId() . "-" . $r->getVariavel()->getId()] = $r->getResultado();
                $totais[$r->getVariavel()->getId()] += $r->getResultado();
            }
        }
        return new ViewModel([
            'amostra' => $amostra,
            'resultados' => $resultados,
            'totais' => $totais
        ]);
    }

}
