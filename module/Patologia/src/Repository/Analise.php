<?php


namespace Patologia\Repository;

use Patologia\Entity\Analise as AnaliseEntity;
use Patologia\Entity\Determinacao;
use Patologia\Entity\Variavel;
use Patologia\Entity\Amostra;
use Patologia\Entity\Resultado;
use Patologia\Entity\Saprofita;

class Analise extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
                ->from(AnaliseEntity::class, 'a')
                ->orderby('a.id', 'ASC');
        return $qb;
    }

    public function create($data) {
        $analise = new AnaliseEntity();
        $analise->setDataInicio($data['dataAtual']);
        $analise->setMetodo($data['metodo']);
        $analise->setAnalista($data['user']);

        $this->getEntityManager()->persist($analise);
        $this->getEntityManager()->flush();

        $determinacoes = $this->getEntityManager()->getRepository(Determinacao::class)->findAll();
        foreach ($determinacoes as $determinacao) {
            $variavel = new Variavel();
            $variavel->setDeterminacao($determinacao);
            $variavel->setAnalise($analise);
            $this->getEntityManager()->persist($variavel);
        }
        $this->getEntityManager()->flush();
        return $analise;
    }

    public function save($data) {
        $amostra = $this->getEntityManager()->find(Amostra::class, $data['amostraId']);
        $analise = $amostra->getAnalise();
        $analise->getSaprofitas()->clear();

        $repeticao = $amostra->getRepeticao($data['repeticaoAtual']);

        if ((null != $repeticao) && ($repeticao->getSequencia() == $data['repeticaoAtual'])) {
            unset($data['repeticaoAtual']);
            unset($data['amostraId']);
            unset($data['numeroLaboratorio']);
            unset($data['submit']);
            unset($data['numeroRepeticoes']);

            foreach ($data as $campo => $valor) {
                $aux = explode("_", $campo);
                if ((count($aux) == 2) && ($aux[0] == 'resultado')) {
                    $variavel = $this->getEntityManager()->find(Variavel::class, $aux[1]);
                    if (null != $variavel) {
                        $resultado = $this->getEntityManager()->getRepository(Resultado::class)->findOneBy(['repeticao' => $repeticao, 'variavel' => $variavel]);
                        if (null == $resultado) {
                            $resultado = new Resultado();
                        }
                        if (null == $valor) {
                            $valor = 0;
                        }
                        $resultado->setResultado($valor);
                        $resultado->setVariavel($variavel);
                        $resultado->setDataLeitura($data['dataAtual']);
                        $resultado->setAnalista($data['user']);
                        $resultado->setRepeticao($repeticao);
                        $this->getEntityManager()->persist($resultado);
                    }
                } else if ($aux[0] == 'saprofita') {
                    $saprofita = $this->getEntityManager()->find(Saprofita::class, $aux[1]);
                    if ($saprofita) {
                        $analise->getSaprofitas()->add($saprofita);
                    }
                }
            }
            $this->getEntityManager()->persist($analise);
        }
        $this->getEntityManager()->flush();
    }

    public function delete($analise) {
        $this->getEntityManager()->remove($analise);
        $this->getEntityManager()->flush();
    }

}
