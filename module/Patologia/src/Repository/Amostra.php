<?php

namespace Patologia\Repository;

use Patologia\Entity\Amostra as AmostraEntity;

use Patologia\Entity\Especie;
use Patologia\Entity\Repeticao;

class Amostra extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
                ->from(AmostraEntity::class, 'a')
                ->orderby('a.id','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('a.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        
        if ( !empty($search['numeroLaboratorio'])){
            $qb->where('a.numeroLaboratorio like :busca');
            $qb->setParameter("busca",'%'.$search['numeroLaboratorio'].'%');
        }
       return $qb;
    }
    
    public function incluir_ou_editar($data) {
        $numeroAmostras = (int) $data['numeroAmostras'];
        $sequenciaNumero = $data['sequenciaNumero'];
        $sequencia = (int) $sequenciaNumero;
        $tamanhoNumero = strlen($sequenciaNumero);
        for ($i = 0; $i < $numeroAmostras; $i++) {
            $zerosEsquerda = "";
            $especie = $this->getEntityManager()->find(Especie::class, $data['especie']);
            $data['dataColheita'] != '' ? $dataColheita = \DateTime::createFromFormat("Y-m-d", $data['dataColheita']) : null;
            $data['dataRecebimento'] != '' ? $dataRecebimento = \DateTime::createFromFormat("Y-m-d", $data['dataRecebimento']) : null;
            $numeroRepeticoes = (int) $data['numeroRepeticoes'];

            while (strlen($zerosEsquerda . $sequencia) < $tamanhoNumero) {
                $zerosEsquerda .= "0";
            }
            $numeroLaboratorio = $data['prefixoNumero'] . $zerosEsquerda . $sequencia . $data['sufixoNumero'];
            $sequencia++;
            $amostra = new AmostraEntity();
            $amostra->setNumeroLaboratorio($numeroLaboratorio);
            $amostra->setEspecie($especie);
            $amostra->setRemetente($data['remetente']);
            $amostra->setLocalColheita($data['localColheita']);
            $amostra->setDataColheita($dataColheita);
            $amostra->setDataRecebimento($dataRecebimento);
            $amostra->setNumeroRepeticoes($numeroRepeticoes);
            $amostra->setStatus(1);
            $amostra->setAnalise(null);

            $this->getEntityManager()->persist($amostra);
            $this->getEntityManager()->flush();

            for ($j = 0; $j < $amostra->getNumeroRepeticoes(); $j++) {
                $repeticao = new Repeticao();
                $sequenciaRepeticao = $j + 1;
                $repeticao->setSequencia($sequenciaRepeticao);
                $repeticao->setAmostra($amostra);
                $this->getEntityManager()->persist($repeticao);
            }
            $this->getEntityManager()->flush();
        }
    }

    public function delete($amostra) {
        $repeticoes = $amostra->getRepeticoes();
        foreach($repeticoes as $repeticao) {
            $this->getEntityManager()->remove($repeticao);
        }
        $this->getEntityManager()->remove($amostra);
        $this->getEntityManager()->flush();
    }
}
