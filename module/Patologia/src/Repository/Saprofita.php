<?php

namespace Patologia\Repository;

use Patologia\Entity\Saprofita as SaprofitaEntity;

class Saprofita extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s')
                ->from(SaprofitaEntity::class, 's')
                ->orderby('s.descricao', 'ASC');

        if (!empty($search['search'])) {
            $qb->where('s.descricao like :busca');
            $qb->setParameter("busca", '%' . $search['search'] . '%');
        }
        return $qb;
    }

    public function incluir_ou_editar($dados, $id = null) {
        $row = null;
        if (!empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro do banco para poder alterar
        }
        if (empty($row)) {
            $row = new SaprofitaEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model no mando ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

    public function delete($saprofita) {
        $this->getEntityManager()->remove($saprofita);
        $this->getEntityManager()->flush();
    }

}
