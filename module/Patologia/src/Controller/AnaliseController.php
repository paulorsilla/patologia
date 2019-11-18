<?php

namespace Patologia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Patologia\Entity\Amostra;
use Patologia\Form\AnaliseForm;
use Patologia\Entity\Metodo;
use Patologia\Entity\Saprofita;
use Patologia\Entity\Resultado;
use Patologia\Entity\Analise;

use User\Entity\User;

class AnaliseController extends AbstractActionController {

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

    public function getObjectManager() {
        return $this->objectManager;
    }

    /**
     * Action para encontrar uma análise já iniciada ou 
     * criar uma nova, caso não exista
     */
    public function findAction() {
        $form = new AnaliseForm($this->getObjectManager());
        $amostra = null;

        if ($this->getRequest()->isPost()) {
            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);
            if ($form->isValid()) {
                $repoAmostra = $this->entityManager->getRepository(Amostra::class);
                $amostra = $repoAmostra->find($data['numeroLaboratorio']);
//                $amostra = $this->entityManager->find(Amostra::class, $data['numeroLaboratorio']);
                if (null == $amostra->getAnalise()) {
                    $repoMetodo = $this->entityManager->getRepository(Metodo::class);
                    $repoUser = $this->entityManager->getRepository(User::class);
                    //criar analise
                    $dados = [];
                    $dados['metodo'] = $repoMetodo->find(1);
                    $dados['user'] = $repoUser->findOneByLogin($this->identity());

                    $dataAtual = new \DateTime();
                    $dataAtual->setTime(0, 0);
                    $dados['dataAtual'] = $dataAtual;

                    $repo = $this->entityManager->getRepository(Analise::class);
                    $analise = $repo->create($dados);
                    $amostra->setAnalise($analise);
                    $amostra->setStatus(2);

                    $this->entityManager->flush();
                }
                return $this->redirect()->toRoute('patologia/analise', ['action' => 'save', 'id' => $amostra->getId()]);
            }
        }
        return new ViewModel([
            'form' => $form,
            'amostra' => $amostra
        ]);
    }
    
    public function startAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('patologia/amostra');
        }

        $repoAmostra = $this->entityManager->getRepository(Amostra::class);
        $amostra = $repoAmostra->find($id);
        if ($amostra) {
            $repoMetodo = $this->entityManager->getRepository(Metodo::class);
            $repoUser = $this->entityManager->getRepository(User::class);
            //criar analise
            $dados = [];
            $dados['metodo'] = $repoMetodo->find(1);
            $dados['user'] = $repoUser->findOneByLogin($this->identity());

            $dataAtual = new \DateTime();
            $dataAtual->setTime(0, 0);
            $dados['dataAtual'] = $dataAtual;

            $repo = $this->entityManager->getRepository(Analise::class);
            $analise = $repo->create($dados);
            $amostra->setAnalise($analise);
            $amostra->setStatus(2);

            $this->entityManager->flush();

            return $this->redirect()->toRoute('patologia/analise', ['action' => 'save', 'id' => $amostra->getId()]);
        }
        
    }

    /**
     * Action para salvar um novo registro
     */
    public function saveAction() {
        //Cria o formulário
        $form = new AnaliseForm($this->getObjectManager());
        $numeroRepeticao = 1;

        $amostra_id = $this->params()->fromRoute('id', 0);
        
        $repoAmostra = $this->entityManager->getRepository(Amostra::class);
        $amostra = $repoAmostra->find($amostra_id);

        //Verifica se a requisição utiliza o método POST
        if ($this->getRequest()->isPost()) {

            //Recebe os dados via POST
            $data = $this->params()->fromPost();

            //Preenche o form com os dados recebidos e o valida
            $form->setData($data);

            if ($form->isValid()) {

                $repoUser = $this->entityManager->getRepository(User::class);
                $data['user'] = $repoUser->findOneByLogin($this->identity());
                
//                $data['user'] = $this->entityManager->getRepository(\User\Entity\User::class)->findOneByLogin($this->identity());
                $dataAtual = new \DateTime();
                $dataAtual->setTime(0, 0);
                $data['dataAtual'] = $dataAtual;
                
                $repo = $this->entityManager->getRepository(Analise::class);
                $repo->save($data);
                if ($data['encerrarAnalise'] == '1') {
                    $amostra->setStatus(3);
                    $this->entityManager->flush();
                    return $this->redirect()->toRoute('patologia/analise', ['action' => 'find']);
                }
                if (null != $data['irParaRepeticao']) {
                    $numeroRepeticao = $data['irParaRepeticao'];
                }
            } else {
                foreach ($form->getMessages() as $k => $e) {
                    error_log($k);
                    foreach ($e as $j => $l) {
                        error_log($j . " => " . $l);
                    }
                }
                return $this->redirect()->toRoute('patologia/amostra', ['action' => 'index']);
            }
        }

        $resultados = null;
        $resultadosAux = $this->entityManager->getRepository(Resultado::class)->findBy(['repeticao' => $amostra->getRepeticao($numeroRepeticao)]);
        foreach ($resultadosAux as $r) {
            $resultados[$r->getVariavel()->getId()] = $r->getResultado();
        }
        $saprofitas = $this->entityManager->getRepository(Saprofita::class)->findAll();
        return new ViewModel([
            'form' => $form,
            'amostra' => $amostra,
            'numeroRepeticao' => $numeroRepeticao,
            'resultados' => $resultados,
            'saprofitas' => $saprofitas
        ]);
    }

}
