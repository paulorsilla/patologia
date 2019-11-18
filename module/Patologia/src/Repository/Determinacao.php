<?php

namespace Patologia\Repository;

use Patologia\Entity\Determinacao as DeterminacaoEntity;

class Determinacao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d')
                ->from(DeterminacaoEntity::class, 'd')
                ->orderby('d.descricao','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('d.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function incluir_ou_editar($dados, $id = null) {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }    
        if ( empty($row)) {
            $row = new DeterminacaoEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

    public function delete($determinacao) {
        $this->getEntityManager()->remove($determinacao);
        $this->getEntityManager()->flush();
    }

}
