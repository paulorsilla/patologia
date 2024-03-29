<?php

namespace Patologia\Repository;

use Patologia\Entity\Metodo as MetodoEntity;

class Metodo extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
                ->from(MetodoEntity::class, 'm')
                ->orderby('m.descricao','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('m.descricao like :busca');
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
            $row = new MetodoEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

    public function delete($metodo) {
        $this->getEntityManager()->remove($metodo);
        $this->getEntityManager()->flush();
    }

}
