<?php

namespace Patologia\Repository;

use Patologia\Entity\Especie as EspecieEntity;

class Especie extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
                ->from(EspecieEntity::class, 'e')
                ->orderby('e.descricao','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('e.descricao like :busca');
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
            $row = new EspecieEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

    public function delete($especie) {
        $this->getEntityManager()->remove($especie);
        $this->getEntityManager()->flush();
    }

}
